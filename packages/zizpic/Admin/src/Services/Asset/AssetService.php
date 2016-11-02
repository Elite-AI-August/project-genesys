<?php

namespace Inventory\Admin\Services\Asset;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\Asset;
use Inventory\Admin\Services\BaseModelService;

/**
 * Class AssetService.
 */
class AssetService extends BaseModelService
{
    /**
     * @var Asset
     */
    protected $model;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param Asset                  $asset
     * @param SentryService          $sentry
     */
    public function __construct(Asset $asset, SentryService $sentry)
    {
        $this->model = $asset;
        $this->sentry = $sentry;
    }

    /**
     * Returns found assets by the specified ID(s).
     *
     * @param int|string|array $ids
     *
     * @return Asset|\Illuminate\Support\Collection
     */
    public function find($ids)
    {
        $records = $this->model->with([
            'meters',
            'category',
            'location',
            'manuals',
            'workOrders',
            'images',
        ])->find($ids);

        if ($records) {
            return $records;
        }
    }

    /**
     * Returns all assets paginated.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getByPageWithFilter($archived = null)
    {
        return $this->model
            ->id($this->getInput('id'))
            ->name($this->getInput('name'))
            ->condition($this->getInput('condition'))
            ->category($this->getInput('category_id'))
            ->location($this->getInput('location_id'))
            ->sort($this->getInput('field'), $this->getInput('sort'))
            ->archived($archived)
            ->paginate(25);
    }

    /**
     * Returns common makes that are inputted into the DB for
     * auto-complete functionality.
     *
     * @param string $make
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMakes($make = null)
    {
        return $this->model
            ->select('make')
            ->distinct()
            ->where('make', 'LIKE', '%'.$make.'%')
            ->get();
    }

    /**
     * Returns common models that are inputted into the DB for
     * auto-complete functionality.
     *
     * @param string $model
     *
     * @return \Illuminate\Support\Collection
     */
    public function getModels($model = null)
    {
        return $this->model
            ->distinct()
            ->select('model')
            ->where('model', 'LIKE', '%'.$model.'%')
            ->get();
    }

    /**
     * Returns common serials that are inputted into
     * the DB for auto-complete functionality.
     *
     * @param string $serial
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSerials($serial = null)
    {
        return $this->model
            ->distinct()
            ->select('serial')
            ->where('serial', 'LIKE', '%'.$serial.'%')
            ->get();
    }

    /**
     * Creates an asset.
     *
     * @return bool|Asset
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {

            /*
             * Set insert data
             */
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'category_id' => $this->getInput('category_id'),
                'location_id' => $this->getInput('location_id'),
                'name' => $this->getInput('name', null, true),
                'condition' => $this->getInput('condition'),
                'vendor' => $this->getInput('vendor', null, true),
                'make' => $this->getInput('make', null, true),
                'model' => $this->getInput('model', null, true),
                'size' => $this->getInput('size', null, true),
                'weight' => $this->getInput('weight', null, true),
                'serial' => $this->getInput('serial', null, true),
                'acquired_at' => $this->formatDateWithTime($this->getInput('acquired_at')),
                'end_of_life' => $this->formatDateWithTime($this->getInput('end_of_life')),
            ];

            /*
             * Create the record and return it upon success
             */
            $record = $this->model->create($insert);

            if ($record) {
                $this->fireEvent('maintenance.assets.created', [
                    'asset' => $record,
                ]);

                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            /*
             * Failed to create record, return false
             */
            return false;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }

    /**
     * Updates an asset record.
     *
     * @param int|string $id
     *
     * @return bool|Asset
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {

            /*
             * Find the asset record
             */
            $record = $this->find($id);

            /*
             * Set update data
             */
            $insert = [
                'location_id' => $this->getInput('location_id', $record->location_id),
                'category_id' => $this->getInput('category_id', $record->category_id),
                'name' => $this->getInput('name', $record->name, true),
                'condition' => $this->getInput('condition', $record->condition),
                'vendor' => $this->getInput('vendor', $record->vendor, true),
                'make' => $this->getInput('make', $record->make, true),
                'model' => $this->getInput('model', $record->model, true),
                'size' => $this->getInput('size', $record->size, true),
                'weight' => $this->getInput('weight', $record->weight, true),
                'serial' => $this->getInput('serial', $record->serial, true),
                'aquired_at' => ($this->formatDateWithTime($this->getInput('aquired_at')) ?: $record->aquired_at),
                'end_of_life' => ($this->formatDateWithTime($this->getInput('end_of_life')) ?: $record->end_of_life),
            ];

            /*
             * Update the record and return it upon success
             */
            if ($record->update($insert)) {
                $this->fireEvent('maintenance.assets.created', [
                    'asset' => $record,
                ]);

                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            /*
             * Failed to update record, return false;
             */
            return false;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }

    /**
     * Deletes the specified asset.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $record = $this->find($id);

        $record->delete();

        $this->fireEvent('maintenance.assets.archived', [
            'asset' => $record,
        ]);

        return true;
    }
}
