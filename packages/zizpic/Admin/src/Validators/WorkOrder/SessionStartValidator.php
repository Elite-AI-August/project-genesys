<?php

namespace Inventory\Admin\Validators\WorkOrder;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Services\WorkOrder\SessionService;

class SessionStartValidator
{
    /**
     * @var SessionService
     */
    protected $session;

    /**
     * Constructor.
     *
     * @param SessionService $session
     * @param SentryService  $sentry
     */
    public function __construct(SessionService $session, SentryService $sentry)
    {
        $this->session = $session;
        $this->sentry = $sentry;
    }

    /**
     * Returns true / false if the specified
     * work order has an open session by the
     * specified user.
     *
     * @param $attribute
     * @param $workOrderId
     * @param $parameters
     *
     * @return bool
     */
    public function validateSessionStart($attribute, $workOrderId, $parameters)
    {
        $sessions = $this->session
            ->where('work_order_id', $workOrderId)
            ->where('user_id', $this->sentry->getCurrentUserId())
            ->latest();

        $lastSession = $sessions->first();

        if($lastSession && $lastSession->out === null) {
            return false;
        }

        return true;
    }
}
