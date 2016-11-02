<?php

namespace Inventory\Admin\Repositories\WorkOrder;

use Carbon\Carbon;
use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\WorkOrderSession;
use Inventory\Admin\Repositories\Repository as BaseRepository;

class SessionRepository extends BaseRepository
{
    /**
     * @var Repository
     */
    protected $workOrder;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param Repository    $workOrder
     * @param SentryService $sentry
     */
    public function __construct(Repository $workOrder, SentryService $sentry)
    {
        $this->workOrder = $workOrder;
        $this->sentry = $sentry;
    }

    /**
     * @return WorkOrderSession
     */
    public function model()
    {
        return new WorkOrderSession();
    }

    /**
     * Returns the specified work order sessions for the specified user.
     *
     * @param int|string $workOrderId
     * @param int|string $userId
     *
     * @return mixed
     */
    public function getSessionsByWorkOrderAndUser($workOrderId, $userId)
    {
        return $this->model()
            ->where('work_order_id', $workOrderId)
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * Creates a new work order session.
     *
     * @param int|string          $workOrderId
     *
     * @return bool|WorkOrderSession
     */
    public function create($workOrderId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        if($workOrder) {
            // Create a new date time string set to now
            $now = Carbon::now()->toDateTimeString();

            // Create a new session
            $session = $this->model();

            // Assign its attributes
            $session->work_order_id = $workOrder->id;
            $session->user_id = $this->sentry->getCurrentUserId();
            $session->in = $now;

            /*
             * If this is the first session that is being created on
             * the work order, set the started at property to now
             */
            if ($workOrder->sessions->count() === 0) {
                $workOrder->update(['started_at' => $now]);
            }

            if($session->save()) {
                return $session;
            }
        }

        return false;
    }

    /**
     * Updates a work order session.
     *
     * @param int|string $workOrderId
     *
     * @return bool|WorkOrderSession
     */
    public function update($workOrderId)
    {
        $session = $this->workOrder->findLastUserSession($workOrderId);

        if($session && $session->user_id === $this->sentry->getCurrentUserId()) {
            $now = Carbon::now()->toDateTimeString();

            $session->out = $now;

            if($session->save()) {
                return $session;
            }
        }

        return false;
    }

}
