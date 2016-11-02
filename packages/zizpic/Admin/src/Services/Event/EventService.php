<?php

namespace Inventory\Admin\Services\Event;

use Inventory\Admin\Services\LocationService;
use Stevebauman\CalendarHelper\Services\Google\EventService as GoogleEventService;
use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\Event;
use Inventory\Admin\Services\BaseModelService;

/**
 * Handles interactions between the Event Model and the Event Api Service.
 */
class EventService extends BaseModelService
{
    /**
     * @var Event
     */
    protected $model;

    /**
     * @var GoogleEventService
     */
    public $eventApi;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var LocationService
     */
    protected $location;

    /**
     * Constructor.
     *
     * @param Event                  $model
     * @param GoogleEventService     $google
     * @param SentryService          $sentry
     * @param LocationService        $location
     */
    public function __construct(
        Event $model,
        GoogleEventService $google,
        SentryService $sentry,
        LocationService $location)
    {
        $this->model = $model;
        $this->eventApi = $google;
        $this->sentry = $sentry;
        $this->location = $location;
    }

    /**
     * Retrieves api events that are in the local database without recurrences.
     *
     * @param array $select
     *
     * @return \Stevebauman\EloquentTable\TableCollection
     */
    public function get($select = [])
    {
        $records = $this->model->where('parent_id', null)->get();

        $events = $this->eventApi->getOnly($records->lists('api_id'));

        return $events;
    }

    /**
     * Returns a collection of all API events.
     *
     * @param array $apiIds
     * @param bool  $recurrences
     *
     * @return mixed|\Stevebauman\EloquentTable\TableCollection
     */
    public function getApiEvents($apiIds = [], $recurrences = false)
    {
        if (count($apiIds) > 0) {
            $events = $this->eventApi->setInput($this->input)->getOnly($apiIds, $recurrences);
        } else {
            $events = $this->eventApi->setInput($this->input)->get();
        }

        return $events;
    }

    /**
     * Returns recurrences from the specified API ID.
     *
     * @param string $api_id
     *
     * @return mixed
     */
    public function getRecurrencesByApiId($api_id)
    {
        $recurrences = $this->eventApi->setInput($this->input)->getRecurrences($api_id);

        return $recurrences;
    }

    /**
     * Retrieves and returns an API event by it's API ID.
     *
     * @param string $api_id
     *
     * @return mixed
     */
    public function findByApiId($api_id)
    {
        $event = $this->eventApi
            ->setInput($this->input)
            ->find($api_id);

        if ($event) {

            /*
             * If the event is a recurrence, we need to create a local
             * record of it so we can attach reports to it.
             */
            if ($event->isRecurrence) {
                $this->createRecurrence($event);
            }

            return $event;
        } else {
            throw new $this->notFoundException();
        }
    }

    /**
     * Creates a local recurrence from the specified parent event.
     *
     * @param $event
     *
     * @return mixed
     */
    public function createRecurrence($event)
    {
        $this->dbStartTransaction();

        /*
         * If the API event exists, make sure it exists in the
         * local database, and the same user ID is used. This is used for
         * making reports on recuring events
         */
        $record = $this->where('api_id', $event->parent_id)->first();

        $insert = [
            'api_id' => $event->id,
            'parent_id' => $record->id,
            'user_id' => $record->user_id,
        ];

        /*
         * Use first or create so we don't create duplicate local recurrence
         * records
         */
        $recurrence = $this->model->firstOrCreate($insert);

        if ($recurrence) {
            $this->dbCommitTransaction();

            return $recurrence;
        }

        $this->dbRollbackTransaction();

        return false;
    }

    /**
     * Retrieves the local database record of the API event.
     *
     * @param string $api_id
     *
     * @return mixed
     */
    public function findLocalByApiId($api_id)
    {
        $event = $this->model
            ->where('api_id', $api_id)
            ->with('assets', 'inventories', 'workOrders')
            ->first();

        if ($event) {
            return $event;
        } else {
            throw new $this->notFoundException();
        }
    }

    /**
     * Creates a google event and then creates a local database record
     * attaching it to whatever created it along with inserting
     * the google event ID.
     *
     * @return mixed
     */
    public function create()
    {
        $data = $this->input;

        /*
         * Find the location and pass the trail into the google event service so
         * it can be seen on google calendar
         */
        if ($this->getInput('location_id')) {
            $location = $this->location->find($this->getInput('location_id'));

            $location_id = $location->id;

            /*
             * Were stripping the tags from the trial because it contains HTML formatting,
             * and google does not display HTML formatting on their calendar
             */
            $data['location'] = strip_tags($location->trail);
        } else {
            /*
             * No location was given, set it to null
             */
            $location_id = null;
        }

        /*
         * Pass the input along to the google event service and create google
         * event
         */
        $event = $this->eventApi->setInput($data)->create();

        /*
         * If the event was created successfully, we now have to attach the specified
         * assets / inventories / work orders to the event
         */
        if ($event) {

            /*
             * Create the main event
             */
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'location_id' => $location_id,
                'api_id' => $event->id,
            ];

            $this->model->create($insert);

            return $event;
        }

        return false;
    }

    /**
     * Updates an event by the specified API ID.
     *
     * @param string $api_id
     *
     * @return bool
     */
    public function updateByApiId($api_id)
    {
        $data = $this->input;

        if ($this->getInput('location_id')) {
            $location = $this->location->find($this->getInput('location_id'));

            /*
             * Were stripping the tags from the trial because it contains HTML formatting,
             * and google does not display such formatting on their calendar
             */
            $data['location'] = strip_tags($location->trail);
        }

        return $this->eventApi->setInput($data)->update($api_id);
    }

    /**
     * Updates the specified event dates.
     *
     * @param $api_id
     *
     * @return mixed
     */
    public function updateDates($api_id)
    {
        return $this->eventApi->setInput($this->input)->updateDates($api_id);
    }

    /**
     * Removes event from the local database calendar and then removes it from
     * the API calendar.
     *
     * @param $api_id
     *
     * @return mixed
     */
    public function destroyByApiId($api_id)
    {
        $this->model->where('api_id', $api_id)->delete();

        return $this->eventApi->destroy($api_id);
    }

    /**
     * Removes local events from the database if the status is cancelled on the
     * API service.
     *
     * @param $events
     */
    public function sync($events)
    {
        foreach ($events as $event) {
            if ($event->status === 'cancelled') {
                $this->model->where('api_id', $event->id)->delete();
            }
        }
    }

    /**
     * Parses a google collection of events into an array of events compatible
     * with FullCalendar.
     *
     * @param $events
     *
     * @return array
     */
    public function parseEvents($events)
    {
        $arrayEvents = [];

        foreach ($events as $event) {
            $startDate = new \DateTime($event->start);
            $endDate = new \DateTime($event->end);

            /*
             * Add the event into a FullCalendar compatible array
             */
            $arrayEvents[] = [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->location,
                'start' => $startDate->format('Y-m-d H:i:s'),
                'end' => $endDate->format('Y-m-d H:i:s'),
                'allDay' => $event->all_day,
            ];
        }

        return $arrayEvents;
    }
}
