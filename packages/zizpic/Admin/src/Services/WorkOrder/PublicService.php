<?php

namespace Inventory\Admin\Services\WorkOrder;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Services\PriorityService;
use Inventory\Admin\Services\StatusService;
use Inventory\Admin\Models\WorkOrder;
use Inventory\Admin\Services\BaseModelService;

/**
 * Class PublicService.
 */
class PublicService extends BaseModelService
{
    /**
     * @var WorkOrder
     */
    protected $model;

    /**
     * @var StatusService
     */
    protected $status;

    /**
     * @var PriorityService
     */
    protected $priority;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param WorkOrder                    $workOrder
     * @param StatusService                $status
     * @param PriorityService              $priority
     * @param SentryService                $sentry
     */
    public function __construct(
        WorkOrder $workOrder,
        StatusService $status,
        PriorityService $priority,
        SentryService $sentry
    ) {
        $this->model = $workOrder;
        $this->status = $status;
        $this->priority = $priority;
        $this->sentry = $sentry;
    }

    /**
     * Returns an eloquent collection of the
     * current logged in users work orders.
     */
    public function getByPageByUser()
    {
        return $this->model->where('user_id', $this->sentry->getCurrentUserId())->paginate(25);
    }

    /**
     * Creates a work order from a public work request.
     *
     * @return bool|WorkOrder
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $status = $this->status->firstOrCreateRequest();
            $priority = $this->priority->firstOrCreateRequest();

            $insert = [
                'status_id' => $status->id,
                'priority_id' => $priority->id,
                'user_id' => $this->sentry->getCurrentUserId(),
                'subject' => $this->getInput('subject', null, true),
                'description' => $this->getInput('description', null, true),
            ];

            $record = $this->model->create($insert);

            if ($record) {
                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Updates the specified work order.
     *
     * @param int|string $id
     *
     * @return bool|mixed
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {
            $record = $this->find($id);

            $insert = [
                'subject' => $this->getInput('subject', $record->subject, true),
                'description' => $this->getInput('description', $record->description, true),
            ];

            if ($record->update($insert)) {
                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Deletes a work order. This will only allow a user to delete their own work orders.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $record = $this->find($id);

        /*
         * Make sure the current logged in
         * User ID equals the work order user id
         */
        if ($record->user_id === $this->sentry->getCurrentUserId()) {
            $record->delete();

            return true;
        }

        return false;
    }
}
