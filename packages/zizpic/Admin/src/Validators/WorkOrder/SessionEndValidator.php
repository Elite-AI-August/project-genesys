<?php

namespace Inventory\Admin\Validators\WorkOrder;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Services\WorkOrder\SessionService;
use Illuminate\Support\Facades\Route;

class SessionEndValidator
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
     * work order session has already ended.
     *
     * @param $attribute
     * @param $workOrderId
     * @param $parameters
     *
     * @return bool
     */
    public function validateSessionEnd($attribute, $workOrderId, $parameters)
    {
        $sessionId = Route::getCurrentRoute()->getParameter('sessions');

        if($sessionId) {
            $session = $this->session->find($sessionId);

            if(!is_null($session->out)) {
                return false;
            }
        }

        return true;
    }
}
