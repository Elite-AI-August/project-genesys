<?php

namespace Inventory\Admin\Repositories\WorkOrder;

use Inventory\Admin\Http\Requests\WorkOrder\StatusRequest;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\Status;
use Inventory\Admin\Repositories\Repository as BaseRepository;

class StatusRepository extends BaseRepository
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param SentryService $sentry
     */
    public function __construct(SentryService $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * @return Status
     */
    public function model()
    {
        return new Status();
    }

    /**
     * Creates a new status.
     *
     * @param StatusRequest $request
     *
     * @return bool|Status
     */
    public function create(StatusRequest $request)
    {
        $status = $this->model();

        $status->user_id = $this->sentry->getCurrentUserId();
        $status->name = $request->input('name');
        $status->color = $request->input('color');

        if($status->save()) {
            return $status;
        }

        return false;
    }

    /**
     * Creates or retrieves a default requested status.
     *
     * @return bool|Status
     */
    public function createDefaultRequested()
    {
        $status = $this->model()->firstOrCreate([
            'name' => 'Requested',
            'color' => 'default',
        ]);

        if($status) {
            return $status;
        }

        return false;
    }

    /**
     * Updates a status.
     *
     * @param StatusRequest $request
     * @param int|string    $id
     *
     * @return bool|Status
     */
    public function update(StatusRequest $request, $id)
    {
        $status = $this->find($id);

        if($status) {
            $status->name = $request->input('name', $status->name);
            $status->color = $request->input('color', $status->color);

            if($status->save()) {
                return $status;
            }
        }

        return false;
    }
}
