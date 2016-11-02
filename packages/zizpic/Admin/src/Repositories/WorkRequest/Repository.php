<?php

namespace Inventory\Admin\Repositories\WorkRequest;

use Inventory\Admin\Http\Requests\WorkRequest\Request;
use Inventory\Admin\Services\ConfigService;
use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Inventory\Admin\Models\WorkRequest;
use Inventory\Admin\Repositories\Repository as BaseRepository;

class Repository extends BaseRepository
{
    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param WorkOrderRepository $workOrder
     * @param SentryService       $sentry
     * @param ConfigService       $config
     */
    public function __construct(WorkOrderRepository $workOrder, SentryService $sentry, ConfigService $config)
    {
        $this->workOrder = $workOrder;
        $this->sentry = $sentry;
        $this->config = $config;
    }

    /**
     * @return WorkRequest
     */
    public function model()
    {
        return new WorkRequest();
    }

    /**
     * Finds a Work Request.
     *
     * @param int|string $id
     *
     * @return null|WorkRequest
     */
    public function find($id)
    {
        $with = [
            'workOrder',
            'updates',
        ];

        return $this->model()->with($with)->find($id);
    }

    /**
     * Creates a new work request.
     *
     * @param Request $request
     *
     * @return bool|WorkRequest
     */
    public function create(Request $request)
    {
        $workRequest = $this->model();

        $workRequest->user_id = $this->sentry->getCurrentUserId();
        $workRequest->subject = $request->input('subject');
        $workRequest->best_time = $request->input('best_time');
        $workRequest->description = $request->clean($request->input('description'));

        if($workRequest->save()) {
            $autoGenerate = $this->config->setPrefix('maintenance')->get('rules.work-orders.auto_generate_from_request', true);

            if($autoGenerate) {
                $this->workOrder->createFromWorkRequest($workRequest);
            }

            return $workRequest;
        }

        return false;
    }

    /**
     * Updates a work request.
     *
     * @param Request $request
     * @param int|string $id
     *
     * @return bool|WorkRequest
     */
    public function update(Request $request, $id)
    {
        $workRequest = $this->model()->findOrFail($id);

        $workRequest->subject = $request->input('subject', $workRequest->subject);
        $workRequest->best_time = $request->input('best_time', $workRequest->best_time);
        $workRequest->description = $request->clean($request->input('description', $workRequest->description));

        if($workRequest->save()) {
            return $workRequest;
        }

        return false;
    }
}
