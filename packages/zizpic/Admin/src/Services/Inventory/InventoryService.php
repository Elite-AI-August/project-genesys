<?php

namespace Inventory\Admin\Services\Inventory;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\Inventory;
use Inventory\Admin\Services\BaseModelService;

/**
 * Class InventoryService.
 */
class InventoryService extends BaseModelService
{
    /**
     * @var Inventory
     */
    protected $model;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param Inventory                  $inventory
     * @param SentryService              $sentry
     */
    public function __construct(Inventory $inventory, SentryService $sentry)
    {
        $this->model = $inventory;
        $this->sentry = $sentry;
    }

    /**
     * Returns all inventory items paginated, with eager
     * loaded relationships, as well as scopes for search.
     *
     * @param bool $archived
     *
     * @return \Stevebauman\EloquentTable\TableCollection
     */
    public function getByPageWithFilter($archived = null)
    {
        return $this->model
            ->with([
                'category',
                'user',
                'stocks',
            ])
            ->id($this->getInput('id'))
            ->name($this->getInput('name'))
            ->description($this->getInput('description'))
            ->category($this->getInput('category_id'))
            ->sku($this->getInput('sku'))
            ->stock(
                $this->getInput('operator'),
                $this->getInput('quantity')
            )
            ->archived($archived)
            ->noVariants()
            ->sort($this->getInput('field'), $this->getInput('sort'))
            ->paginate(25);
    }

    /**
     * Creates an item record.
     *
     * @return Inventory
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            // Set insert data
            $insert = [
                'category_id' => $this->getInput('category_id'),
                'user_id' => $this->sentry->getCurrentUserId(),
                'metric_id' => $this->getInput('metric'),
                'name' => $this->getInput('name', null, true),
                'description' => $this->getInput('description', null, true),
            ];

            // If the record is created, return it, otherwise return false
            $record = $this->model->create($insert);

            if ($record) {
                // Fire created event
                $this->fireEvent('maintenance.inventory.created', [
                    'item' => $record,
                ]);

                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Creates a variant of the specified item.
     *
     * @param int|string $id
     *
     * @return bool|Inventory
     */
    public function createVariant($id)
    {
        $item = $this->find($id);

        if ($item) {
            $variant = $this->create();

            if ($variant) {
                $variant->makeVariantOf($item);

                return $variant;
            }
        }

        return false;
    }

    /**
     * Updates an item record.
     *
     * @param int|string $id
     *
     * @return bool|Inventory
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {
            // Find the item record
            $record = $this->find($id);

            // Set update data
            $insert = [
                'category_id' => $this->getInput('category_id', $record->category_id),
                'metric_id' => $this->getInput('metric'),
                'name' => $this->getInput('name', $record->name, true),
                'description' => $this->getInput('description', $record->description, true),
            ];

            // Update the record, return it upon success
            if ($record->update($insert)) {

                // Fire updated event
                $this->fireEvent('maintenance.inventory.updated', [
                    'item' => $record,
                ]);

                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /*
     * Archives an item record
     *
     * @return bool
     */
    public function destroy($id)
    {
        $record = $this->find($id);

        $record->delete();

        /*
         * Fire archived event
         */
        $this->fireEvent('maintenance.inventory.archived', [
            'item' => $record,
        ]);

        return true;
    }
}
