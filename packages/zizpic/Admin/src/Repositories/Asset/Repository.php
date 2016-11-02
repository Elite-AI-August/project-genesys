<?php

namespace Inventory\Admin\Repositories\Asset;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Http\Requests\Asset\Request;
use Inventory\Admin\Models\Asset;
use Inventory\Admin\Repositories\Repository as BaseRepository;

class Repository extends BaseRepository
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param SentryService $sentry
     */
    public function __construct(SentryService $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * @return Asset
     */
    public function model()
    {
        return new Asset();
    }

    /**
     * Finds an Asset.
     *
     * @param int|string $id
     *
     * @return null|Asset
     */
    public function find($id)
    {
        $with = [
            'location',
            'category',
            'workOrders',
            'images',
            'meters',
            'revisionHistory',
        ];

        return $this->model()->with($with)->findOrFail($id);
    }

    /**
     * Returns a new grid instance of all asset work orders.
     *
     * @param int|string $assetId
     * @param array      $columns
     * @param array      $settings
     * @param null       $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridWorkOrders($assetId, array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->find($assetId);

        return $this->newGrid($model->workOrders(), $columns, $settings, $transformer);
    }

    /**
     * Creates a new Asset.
     *
     * @param Request $request
     *
     * @return bool|Asset
     */
    public function create(Request $request)
    {
        $asset = $this->model();

        $asset->user_id = $this->sentry->getCurrentUserId();
        $asset->location_id = $request->input('location_id');
        $asset->category_id = $request->input('category_id');
        $asset->tag = $request->input('tag');
        $asset->name = $request->input('name');
        $asset->description = $request->clean($request->input('description'));
        $asset->condition = $request->input('condition');
        $asset->size = $request->input('size');
        $asset->weight = $request->input('weight');
        $asset->vendor = $request->input('vendor');
        $asset->make = $request->input('make');
        $asset->model = $request->input('model');
        $asset->serial = $request->input('serial');
        $asset->price = $request->input('price');

        if($request->input('acquired_at')) {
            $asset->acquired_at = $this->strToDate($request->input('acquired_at'));
        }

        if($request->input('end_of_life')) {
            $asset->end_of_life = $this->strToDate($request->input('end_of_life'));
        }

        if($asset->save()) {
            return $asset;
        }

        return false;
    }

    /**
     * Updates the specified Asset.
     *
     * @param Request    $request
     * @param int|string $id
     *
     * @return bool|Asset
     */
    public function update(Request $request, $id)
    {
        $asset = $this->find($id);

        if($asset) {

            $asset->location_id = $request->input('location_id', $asset->location_id);
            $asset->category_id = $request->input('category_id', $asset->category_id);
            $asset->tag = $request->input('tag', $asset->tag);
            $asset->name = $request->input('name', $asset->name);
            $asset->description = $request->clean($request->input('description', $asset->name));
            $asset->condition = $request->input('condition', $asset->condition);
            $asset->size = $request->input('size', $asset->size);
            $asset->weight = $request->input('weight', $asset->weight);
            $asset->vendor = $request->input('vendor', $asset->vendor);
            $asset->make = $request->input('make', $asset->make);
            $asset->model = $request->input('model', $asset->model);
            $asset->serial = $request->input('serial', $asset->serial);
            $asset->price = $request->input('price', $asset->price);

            if($request->input('acquired_at')) {
                $asset->acquired_at = $this->strToDate($request->input('acquired_at', $asset->acquired_at));
            }

            if($request->input('end_of_life')) {
                $asset->end_of_life = $this->strToDate($request->input('end_of_life', $asset->end_of_life));
            }

            if($asset->save()) {
                return $asset;
            }
        }

        return false;
    }
}
