<?php

namespace Inventory\Admin\Services;

use Inventory\Admin\Models\Priority;

/**
 * Class PriorityService.
 */
class PriorityService extends BaseModelService
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param Priority      $priority
     * @param SentryService $sentry
     */
    public function __construct(Priority $priority, SentryService $sentry)
    {
        $this->model = $priority;
        $this->sentry = $sentry;
    }

    /**
     * Creates a priority.
     *
     * @return bool|Priority
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'name' => $this->getInput('name'),
                'color' => $this->getInput('color'),
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
     * Updates the specified priority.
     *
     * @param string $id
     *
     * @return bool|Priority
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {
            $record = $this->find($id);

            $insert = [
                'name' => $this->getInput('name'),
                'color' => $this->getInput('color'),
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
     * Creates or returns the default 'Requested' priority.
     *
     * @return bool|Priority
     */
    public function firstOrCreateRequest()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'name' => 'Requested',
                'color' => 'default',
            ];

            $record = $this->model->firstOrCreate($insert);

            $this->dbCommitTransaction();

            return $record;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }
}
