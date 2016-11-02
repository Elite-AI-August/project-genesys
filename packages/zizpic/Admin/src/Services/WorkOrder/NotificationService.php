<?php

namespace Inventory\Admin\Services\WorkOrder;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\WorkOrderNotification;
use Inventory\Admin\Services\BaseModelService;

/**
 * Class NotificationService
 */
class NotificationService extends BaseModelService
{
    /**
     * @var WorkOrderNotification
     */
    protected $model;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param WorkOrderNotification $model
     * @param SentryService $sentry
     */
    public function __construct(WorkOrderNotification $model, SentryService $sentry)
    {
        $this->model = $model;
        $this->sentry = $sentry;
    }

    /**
     * Creates a notification record for a user
     * indicating what they would like to be notified
     * about.
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'work_order_id' => $this->getInput('work_order_id'),
                'status' => $this->getInput('status', 0),
                'priority' => $this->getInput('priority', 0),
                'parts' => $this->getInput('parts', 0),
                'customer_updates' => $this->getInput('customer_updates', 0),
                'technician_updates' => $this->getInput('technician_updates', 0),
                'completion_report' => $this->getInput('completion_report', 0),
            ];

            $record = $this->model->create($insert);

            $this->dbCommitTransaction();

            return $record;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }

    /**
     * Updates the notification record for a user
     * indicating what they would like to be notified
     * about.
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
                'status' => $this->getInput('status', 0),
                'priority' => $this->getInput('priority', 0),
                'parts' => $this->getInput('parts', 0),
                'customer_updates' => $this->getInput('customer_updates', 0),
                'technician_updates' => $this->getInput('technician_updates', 0),
                'completion_report' => $this->getInput('completion_report', 0),
            ];

            if ($record->update($insert)) {
                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            return false;
        } catch (\Exception $e) {
            $this->dbCommitTransaction();

            return false;
        }
    }
}
