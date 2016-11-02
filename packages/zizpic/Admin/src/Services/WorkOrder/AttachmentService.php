<?php

namespace Inventory\Admin\Services\WorkOrder;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Services\AttachmentService as BaseAttachmentService;
use Inventory\Admin\Services\BaseModelService;

/**
 * Class AttachmentService.
 */
class AttachmentService extends BaseModelService
{
    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var BaseAttachmentService
     */
    protected $attachment;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param WorkOrderService      $workOrder
     * @param BaseAttachmentService $attachment
     * @param SentryService         $sentry
     */
    public function __construct(
        WorkOrderService $workOrder,
        BaseAttachmentService $attachment,
        SentryService $sentry
    ) {
        $this->workOrder = $workOrder;
        $this->attachment = $attachment;
        $this->sentry = $sentry;
    }

    /**
     * Creates attachment records, attaches them to the asset images pivot table,
     * and moves the uploaded file into it's stationary position (out of the temp folder).
     *
     * @return array|bool
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            // Find the work order
            $workOrder = $this->workOrder->find($this->getInput('work_order_id'));

            $uploadDir = $this->getInput('file_path');

            // Check if any files have been uploaded
            $files = $this->getInput('files');

            if ($uploadDir && $files) {
                $records = [];

                // For each file, create the attachment record, and sync asset image pivot table
                foreach ($files as $file) {
                    $insert = [
                        'file_name' => $file,
                        'file_path' => $uploadDir.$file,
                        'user_id' => $this->sentry->getCurrentUserId(),
                    ];

                    // Create the attachment record
                    $attachment = $this->attachment->setInput($insert)->create();

                    // Attach the attachment record to the work order attachments
                    $workOrder->attachments()->attach($attachment);

                    $records[] = $attachment;
                }

                $this->dbCommitTransaction();

                // Return attachment record on success
                return $records;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
