<?php

namespace Inventory\Admin\Services\Meter;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\MeterReading;
use Inventory\Admin\Services\BaseModelService;

/**
 * Class ReadingService
 */
class ReadingService extends BaseModelService
{
    /**
     * @var MeterReading
     */
    protected $model;

    /**
     * Constructor.
     *
     * @param MeterReading $meterReading
     * @param SentryService $sentry
     */
    public function __construct(MeterReading $meterReading, SentryService $sentry)
    {
        $this->model = $meterReading;
        $this->sentry = $sentry;
    }

    public function getByMeterByPageWithFilter($meter_id)
    {
        return $this->model
            ->where('meter_id', $meter_id)
            ->orderBy('created_at', 'DESC')
            ->paginate(25);
    }

    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'meter_id' => $this->getInput('meter_id'),
                'reading' => $this->getInput('reading'),
                'comment' => $this->getInput('comment'),
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
                'reading' => $this->getInput('reading'),
                'comment' => $this->getInput('comment'),
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
