<?php

namespace Inventory\Admin\Services\Meter;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\Meter;
use Inventory\Admin\Services\BaseModelService;

/**
 * Class MeterService
 */
class MeterService extends BaseModelService
{
    /**
     * @var Meter
     */
    protected $model;

    /**
     * Constructor.
     *
     * @param Meter $meter
     * @param SentryService $sentry
     */
    public function __construct(Meter $meter, SentryService $sentry)
    {
        $this->model = $meter;
        $this->sentry = $sentry;
    }

    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'metric_id' => $this->getInput('metric'),
                'name' => $this->getInput('name'),
            ];

            $record = $this->model->create($insert);

            $this->dbCommitTransaction();

            return $record;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }

    public function update($id)
    {
        $this->dbStartTransaction();

        try {
            $record = $this->find($id);

            $insert = [
                'metric_id' => $this->getInput('metric'),
                'name' => $this->getInput('name'),
            ];

            if ($record->update($insert)) {
                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            return false;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }
}
