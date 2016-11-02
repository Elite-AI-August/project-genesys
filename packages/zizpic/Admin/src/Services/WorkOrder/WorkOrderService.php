<?php

namespace Inventory\Admin\Services\WorkOrder;

use Inventory\Admin\Services\ConfigService;
use Inventory\Admin\Services\PriorityService;
use Inventory\Admin\Services\StatusService;
use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\WorkRequest;
use Inventory\Admin\Models\WorkOrder;
use Inventory\Admin\Services\BaseModelService;

/**
 * Class WorkOrderService.
 */
class WorkOrderService extends BaseModelService
{
    /**
     * @var WorkOrder
     */
    protected $model;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var PriorityService
     */
    protected $priority;

    /**
     * @var StatusService
     */
    protected $status;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param WorkOrder                  $workOrder
     * @param SentryService              $sentry
     * @param PriorityService            $priority
     * @param StatusService              $status
     * @param ConfigService              $config
     */
    public function __construct(
        WorkOrder $workOrder,
        SentryService $sentry,
        PriorityService $priority,
        StatusService $status,
        ConfigService $config
    ) {
        $this->model = $workOrder;
        $this->sentry = $sentry;
        $this->priority = $priority;
        $this->status = $status;
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * Returns a collection of all work orders
     * with query scopes for search functionality.
     *
     * @param bool $archived
     *
     * @return \Illuminate\Support\Collection
     */
    public function getByPageWithFilter($archived = null)
    {
        return $this
            ->model
            ->with([
                'category',
                'user',
                'sessions',
            ])
            ->id($this->getInput('id'))
            ->priority($this->getInput('priority'))
            ->subject($this->getInput('subject'))
            ->assets($this->getInput('assets'))
            ->description($this->getInput('description'))
            ->status($this->getInput('status'))
            ->category($this->getInput('category_id'))
            ->sort($this->getInput('field'), $this->getInput('sort'))
            ->archived($archived)
            ->paginate(25);
    }

    /**
     * Retrieves work orders for the currently logged in user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUserAssignedWorkOrders()
    {
        return $this->model
            ->with([
                'status',
                'category',
                'user',
            ])
            ->assignedUser($this->sentry->getCurrentUserId())
            ->paginate(25);
    }

    /**
     * Creates a work order.
     *
     * @return \Inventory\Admin\Models\WorkOrder|bool
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'category_id' => $this->getInput('category_id'),
                'location_id' => $this->getInput('location_id'),
                'status_id' => $this->getInput('status'),
                'priority_id' => $this->getInput('priority'),
                'subject' => $this->getInput('subject', null, true),
                'description' => $this->getInput('description', null, true),
                'started_at' => $this->getInput('started_at'),
                'completed_at' => $this->getInput('completed_at'),
            ];

            $record = $this->model->create($insert);

            $assets = $this->getInput('assets');

            if ($assets) {
                $record->assets()->attach($assets);
            }

            $this->fireEvent('maintenance.work-orders.created', [
                'workOrder' => $record,
            ]);

            $this->dbCommitTransaction();

            return $record;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Creates a work order from the specified work request.
     *
     * @param WorkRequest $workRequest
     *
     * @return WorkOrder|bool
     */
    public function createFromWorkRequest(WorkRequest $workRequest)
    {
        $this->dbStartTransaction();

        /*
         * We'll make sure the work request doesn't already have a
         * work order attached to it before we try and create it
         */
        if (!$workRequest->workOrder) {
            try {
                // Retrieve the default submission status for work orders
                $statusData = $this->config->get('rules.work-requests.submission_status');

                // Create or find the status if it doesn't exist
                $status = $this
                    ->status
                    ->setInput($statusData)
                    ->firstOrCreate();

                // Retrieve the default submission priority for work orders
                $priorityData = $this->config->get('rules.work-requests.submission_priority');

                // Create or find the priority if it doesn't exist
                $priority = $this
                    ->priority
                    ->setInput($priorityData)
                    ->firstOrCreate();

                // Set the work order insert data
                $insert = [
                    'status_id' => $status->id,
                    'priority_id' => $priority->id,
                    'request_id' => $workRequest->id,
                    'user_id' => $workRequest->user_id,
                    'subject' => $workRequest->subject,
                    'description' => $workRequest->description,
                ];

                // Create the work order
                $workOrder = $this->model->create($insert);

                if ($workOrder) {
                    // Commit the transaction on success
                    $this->dbCommitTransaction();

                    return $workOrder;
                }
            } catch (\Exception $e) {
                $this->dbRollbackTransaction();
            }
        }

        return false;
    }

    /**
     * Updates the specified work order.
     *
     * @param string|int $id
     *
     * @return \Inventory\Admin\Models\WorkOrder|bool
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {
            $record = $this->find($id);

            $insert = [
                'category_id' => $this->getInput('category_id', $record->category_id),
                'location_id' => $this->getInput('location_id', $record->location_id),
                'status_id' => $this->getInput('status', $record->status->id),
                'priority_id' => $this->getInput('priority', $record->priority->id),
                'subject' => $this->getInput('subject', $record->subject, true),
                'description' => $this->getInput('description', $record->description, true),
                'started_at' => $this->getInput('started_at', $record->started_at),
                'completed_at' => $this->getInput('completed_at', $record->completed_at),
            ];

            if ($record->update($insert)) {
                $assets = $this->getInput('assets');

                if ($assets) {
                    $record->assets()->sync($assets);
                }

                $this->fireEvent('maintenance.work-orders.updated', [
                    'workOrder' => $record,
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
     * Deletes the specified work order.
     *
     * @param string|int $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $this->dbStartTransaction();

        try {
            $record = $this->find($id);

            $record->delete();

            $this->fireEvent('maintenance.work-orders.destroyed', [
                'workOrder' => $record,
            ]);

            $this->dbCommitTransaction();

            return true;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Attaches a stock item to a work order as a 'part'.
     *
     * @param \Inventory\Admin\Models\WorkOrder      $workOrder
     * @param \Inventory\Admin\Models\InventoryStock $stock
     *
     * @return bool
     */
    public function savePart($workOrder, $stock)
    {
        $this->dbStartTransaction();

        try {
            // Find if the stock ('part') is already attached to the work order
            $part = $workOrder->parts->find($stock->id);

            if ($part) {
                // Add on the quantity inputted to the existing record quantity
                $newQuantity = $part->pivot->quantity + $this->getInput('quantity');

                /*
                 * Update the existing pivot record
                 */
                $workOrder->parts()->updateExistingPivot($part->id, ['quantity' => $newQuantity]);
            } else {
                // Part Record does not exist, attach a new record with quantity inputted
                $workOrder->parts()->attach($stock->id, ['quantity' => $this->getInput('quantity')]);
            }

            /*
             * Fire the event for notifications
             */
            $this->fireEvent('maintenance.work-orders.parts.created', [
                'workOrder' => $workOrder,
                'stock' => $stock,
            ]);

            $this->dbCommitTransaction();

            return true;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Attaches an update to the work order pivot table.
     *
     * @param WorkOrder                              $workOrder
     * @param \Inventory\Admin\Models\Update $update
     *
     * @return bool
     */
    public function saveUpdate($workOrder, $update)
    {
        $this->dbStartTransaction();

        try {
            if ($workOrder->updates()->save($update)) {
                $this->fireEvent('maintenance.work-orders.updates.created', [
                    'workOrder' => $workOrder,
                    'update' => $update,
                ]);

                $this->dbCommitTransaction();

                return true;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
