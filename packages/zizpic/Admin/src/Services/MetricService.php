<?php

namespace Inventory\Admin\Services;

use Inventory\Admin\Models\Metric;

/**
 * Class MetricService.
 */
class MetricService extends BaseModelService
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param Metric                  $metric
     * @param SentryService           $sentry
     */
    public function __construct(Metric $metric, SentryService $sentry)
    {
        $this->model = $metric;
        $this->sentry = $sentry;
    }

    /**
     * Retrieves all metrics.
     *
     * @param array $select
     *
     * @return mixed
     */
    public function get($select = [])
    {
        return $this->model->sort($this->getInput('field'), $this->getInput('sort'))->get();
    }

    /**
     * Processes creating a metric.
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'name' => $this->getInput('name'),
                'symbol' => $this->getInput('symbol'),
            ];

            $record = $this->model->create($insert);

            $this->dbCommitTransaction();

            return $record;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Processes updating the specified metric.
     *
     * @param int|string $id
     *
     * @return bool|mixed
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'name' => $this->getInput('name'),
                'symbol' => $this->getInput('symbol'),
            ];

            $record = $this->find($id);

            if ($record->update($insert)) {
                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
