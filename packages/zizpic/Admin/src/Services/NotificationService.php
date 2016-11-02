<?php

namespace Inventory\Admin\Services;

use Inventory\Admin\Models\Notification;

class NotificationService extends BaseModelService
{
    public function __construct(Notification $notification)
    {
        $this->model = $notification;
    }

    public function update($id)
    {
        $this->dbStartTransaction();

        try {
            $notification = $this->find($id);

            $insert = [
                'read' => $this->getInput('read'),
            ];

            if ($notification->update($insert)) {
                $this->dbCommitTransaction();

                return $notification;
            }

            $this->dbRollbackTransaction();

            return false;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }
}
