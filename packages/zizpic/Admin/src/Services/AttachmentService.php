<?php

namespace Inventory\Admin\Services;

use Inventory\Admin\Models\Attachment;

/**
 * Class AttachmentService
 */
class AttachmentService extends BaseModelService
{
    /**
     * @var Attachment
     */
    protected $model;

    /**
     * Constructor.
     *
     * @param Attachment $attachment
     */
    public function __construct(Attachment $attachment)
    {
        $this->model = $attachment;
    }

    /**
     * Creates a new attachment record.
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $record = $this->model->create($this->input);

            $this->dbCommitTransaction();

            return $record;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }
}
