<?php

namespace Inventory\Admin\Repositories;

use Inventory\Admin\Http\Requests\Event\ReportRequest;
use Inventory\Admin\Http\Requests\Event\Request;
use Stevebauman\CalendarHelper\Services\Google\EventService as GoogleEventService;
use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\Event;

class EventRepository extends Repository
{
    /**
     * @var LocationRepository
     */
    protected $location;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var GoogleEventService
     */
    protected $eventApi;

    /**
     * @param LocationRepository $location
     * @param SentryService      $sentry
     * @param GoogleEventService $eventApi
     */
    public function __construct(LocationRepository $location, SentryService $sentry, GoogleEventService $eventApi)
    {
        $this->location = $location;
        $this->sentry = $sentry;
        $this->eventApi = $eventApi;
    }

    /**
     * @return Event
     */
    public function model()
    {
        return new Event();
    }

    /**
     * {@inheritDoc}
     */
    public function grid(array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->model();

        $model->whereNull('parent_id');

        return parent::newGrid($model, $columns, $settings, $transformer);
    }

    /**
     * Returns the events recurrences by it's Api ID.
     *
     * @param int|string $id
     *
     * @return mixed
     */
    public function getRecurrencesByApiId($id)
    {
        $filter = [
            'timeMin' => strToRfc3339(strtotime('now')),
            'timeMax' => strToRfc3339(strtotime('+1 month')),
        ];

        return $this->eventApi->setInput($filter)->getRecurrences($id);
    }

    /**
     * Finds a google event object by it's API ID.
     *
     * @param int|string $id
     *
     * @return bool|mixed
     */
    public function findApiObject($id)
    {
        $event = $this->eventApi->find($id);

        if($event) {
            return $event;
        }

        return false;
    }

    /**
     * Creates a new event.
     *
     * @param Request $request
     *
     * @return bool|Event
     */
    public function create(Request $request)
    {
        $input = $request->all();

        if(array_key_exists('location_id', $input)) {

            $location = $this->location->find($input['location_id']);

            if($location) {
                $input['location'] = strip_tags($location->trail);
            }
        }

        $apiEvent = $this->eventApi->setInput($request->all())->create();

        if($apiEvent) {
            $event = $this->model();

            $event->user_id = $this->sentry->getCurrentUserId();
            $event->location_id = $request->input('location_id', null);
            $event->api_id = $apiEvent->id;

            if($event->save()) {
                return $event;
            }
        }

        return false;
    }

    /**
     * Creates a new report for the specified event.
     *
     * @param ReportRequest $request
     * @param int|string $id
     *
     * @return bool
     */
    public function createReport(ReportRequest $request, $id)
    {
        $event = $this->find($id);

        if($event) {
            $insert = [
                'description' => $request->clean($request->input('description')),
            ];

            $report = $event->report()->create($insert);

            if($report) {
                return $report;
            }
        }

        return false;
    }

    public function update(Request $request, $id)
    {

    }
}
