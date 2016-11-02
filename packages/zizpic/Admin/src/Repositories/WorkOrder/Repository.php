<?php

namespace Inventory\Admin\Repositories\WorkOrder;

use Inventory\Admin\Exceptions\NotEnoughStockException;
use Inventory\Admin\Http\Requests\WorkOrder\Part\TakeRequest;
use Inventory\Admin\Http\Requests\WorkOrder\Part\ReturnRequest;
use Inventory\Admin\Http\Requests\WorkOrder\Request;
use Inventory\Admin\Services\ConfigService;
use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\WorkRequest;
use Inventory\Admin\Models\WorkOrder;
use Inventory\Admin\Repositories\Repository as BaseRepository;

class Repository extends BaseRepository
{
    /**
     * @var StatusRepository
     */
    protected $status;

    /**
     * @var PriorityRepository
     */
    protected $priority;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param StatusRepository   $status
     * @param PriorityRepository $priority
     * @param SentryService      $sentry
     * @param ConfigService      $config
     */
    public function __construct(
        StatusRepository $status,
        PriorityRepository $priority,
        SentryService $sentry,
        ConfigService $config
    ) {
        $this->status = $status;
        $this->priority = $priority;
        $this->sentry = $sentry;
        $this->config = $config;
    }

    /**
     * @return WorkOrder
     */
    public function model()
    {
        return new WorkOrder();
    }

    /**
     * Finds a Work Order.
     *
     * @param int|string $id
     *
     * @return null|WorkOrder
     */
    public function find($id)
    {
        $with = [
            'sessions',
            'events',
            'parts',
            'category',
            'location',
            'attachments',
        ];

        return $this->model()->with($with)->find($id);
    }

    /**
     * Finds a part attached to a work order.
     *
     * @param int|string $id
     * @param int|string $stockId
     *
     * @return bool
     */
    public function findPartByWorkOrderIdAndStockId($id, $stockId)
    {
        $workOrder = $this->find($id);

        if($workOrder) {
            return $workOrder->parts()->findOrFail($stockId);
        }

        return false;
    }

    /**
     * Finds the last current users session record.
     *
     * @param int|string $workOrderId
     *
     * @return null|\Inventory\Admin\Models\WorkOrderSession
     */
    public function findLastUserSession($workOrderId)
    {
        $workOrder = $this->find($workOrderId);

        return $workOrder
            ->sessions()
            ->where('user_id', $this->sentry->getCurrentUserId())
            ->first();
    }

    /**
     * Retrieves all of the current users assigned work orders.
     *
     * @param array    $columns
     * @param array    $settings
     * @param \Closure $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridAssigned(array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->model()->assignedUser($this->sentry->getCurrentUserId());

        return $this->newGrid($model, $columns, $settings, $transformer);
    }

    /**
     * Retrieves all of the current sessions for the specified work order.
     *
     * @param int|string $workOrderId
     * @param array      $columns
     * @param array      $settings
     * @param \Closure   $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridSessions($workOrderId, array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->find($workOrderId);

        return $this->newGrid($model->sessions(), $columns, $settings, $transformer);
    }

    /**
     * Retrieves all of the current parts for the specified work order.
     *
     * @param int|string $workOrderId
     * @param array      $columns
     * @param array      $settings
     * @param \Closure   $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridParts($workOrderId, array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->find($workOrderId);

        return $this->newGrid($model->parts(), $columns, $settings, $transformer);
    }

    /**
     * Creates a new work order.
     *
     * @param Request $request
     *
     * @return bool|WorkOrder
     */
    public function create(Request $request)
    {
        $workOrder = $this->model();

        $workOrder->user_id = $this->sentry->getCurrentUserId();
        $workOrder->category_id = $request->input('category_id');
        $workOrder->location_id = $request->input('location_id');
        $workOrder->status_id = $request->input('status_id');
        $workOrder->priority_id = $request->input('priority_id');
        $workOrder->subject = $request->input('subject');
        $workOrder->description = $request->clean($request->input('description'));
        $workOrder->started_at = $request->input('started_at');
        $workOrder->completed_at = $request->input('completed_at');

        if($workOrder->save()) {

            $assets = $request->input('assets');

            if(count($assets) > 0) {
                $workOrder->assets()->attach($assets);
            }

            return $workOrder;
        }

        return false;
    }

    /**
     * Creates a new work order from a work request.
     *
     * @param WorkRequest $workRequest
     *
     * @return bool|WorkOrder
     */
    public function createFromWorkRequest(WorkRequest $workRequest)
    {
        /*
         * We'll make sure the work request doesn't already have a
         * work order attached to it before we try and create it
         */
        if (!$workRequest->workOrder) {
            $priority = $this->priority->createDefaultRequested();

            $status = $this->status->createDefaultRequested();

            $workOrder = $this->model();

            $workOrder->status_id = $status->id;
            $workOrder->priority_id = $priority->id;
            $workOrder->request_id = $workRequest->id;
            $workOrder->user_id = $workRequest->user_id;
            $workOrder->subject = $workRequest->subject;
            $workOrder->description = $workRequest->description;

            if ($workOrder->save()) {
                return $workOrder;
            }
        }

        return false;
    }

    /**
     * Updates a work order.
     *
     * @param Request    $request
     * @param int|string $id
     *
     * @return bool|WorkOrder
     */
    public function update(Request $request, $id)
    {
        $workOrder = $this->find($id);

        $workOrder->category_id = $request->input('category_id', $workOrder->category_id);
        $workOrder->location_id = $request->input('location_id', $workOrder->location_id);
        $workOrder->status_id = $request->input('status_id', $workOrder->status_id);
        $workOrder->priority_id = $request->input('priority_id', $workOrder->priority_id);
        $workOrder->subject = $request->input('subject', $workOrder->subject);
        $workOrder->description = $request->clean($request->input('description', $workOrder->description));
        $workOrder->started_at = $request->input('started_at', $workOrder->started_at);
        $workOrder->completed_at = $request->input('completed_at', $workOrder->completed_at);

        if($workOrder->save()) {

            $assets = $request->input('assets', $workOrder->assets);

            if(count($assets) > 0) {
                $workOrder->assets()->attach($assets);
            }

            return $workOrder;
        }

        return false;
    }

    /**
     * Removes the requested quantity from the specified
     * stock and attaches it to the specified work order.
     *
     * @param TakeRequest $request
     * @param int|string $workOrderId
     * @param int|string $stockId
     *
     * @return bool|WorkOrder
     */
    public function takePart(TakeRequest $request, $workOrderId, $stockId)
    {
        $workOrder = $this->find($workOrderId);

        if($workOrder) {
            // Check if the stock is already attached to the work order
            $stock = $workOrder->parts()->find($stockId);

            $quantity = $request->input('quantity');

            $reason = sprintf('Used for <a href="%s">Work Order</a>', route('maintenance.work-orders.show', [$workOrder->id]));

            try {
                if($stock && $stock->take($quantity, $reason)) {
                    // Add on the quantity inputted to the existing record quantity
                    $newQuantity = $stock->pivot->quantity + $quantity;

                    if($workOrder->parts()->updateExistingPivot($stock->id, ['quantity' => $newQuantity])) {
                        return $workOrder;
                    }
                } else {
                    /*
                     * The stock hasn't been attached to the work
                     * order. We'll try to find it and attach it now.
                     */
                    $stock = $workOrder->parts()->getRelated()->find($stockId);

                    if($stock && $stock->take($quantity, $reason)) {
                        if($workOrder->parts()->attach($stock->id, ['quantity' => $quantity])) {
                            return $workOrder;
                        }
                    }
                }
            } catch (NotEnoughStockException $e) {}
        }

        return false;
    }

    /**
     * Returns quantity that was taken for a work order back into it's original stock.
     *
     * @param ReturnRequest  $request
     * @param int|string     $workOrderId
     * @param int|string     $stockId
     *
     * @return bool|WorkOrder
     */
    public function returnPart(ReturnRequest $request, $workOrderId, $stockId)
    {
        $workOrder = $this->find($workOrderId);

        $stock = $workOrder->parts()->find($stockId);

        if($stock) {
            // Get the requested quantity to return
            $quantity = $request->input('quantity');

            if($quantity > $stock->pivot->quantity) {
                /*
                 * If the quantity entered is greater than
                 * the taken stock, we'll return all of the stock.
                 */
                $returnQuantity = $stock->pivot->quantity;
            } else {
                // Otherwise we can use the users quantity input.
                $returnQuantity = $quantity;
            }

            // Set the stock put reason
            $reason = sprintf('Put back from <a href="%s">Work Order</a>', route('maintenance.work-orders.show', [$workOrder->id]));

            if($stock->put($returnQuantity, $reason)) {

                $newQuantity = $stock->pivot->quantity - $returnQuantity;

                if($newQuantity == 0) {
                    /*
                     * If the new quantity is zero, we'll detach
                     * the stock record from the work order parts.
                     */
                    $workOrder->parts()->detach($stock->id);
                } else {
                    /*
                     * Otherwise we'll update the quantity on the pivot record.
                     */
                    $workOrder->parts()->updateExistingPivot($stock->id, ['quantity' => $newQuantity]);
                }

                return $workOrder;
            }
        }

        return false;
    }
}
