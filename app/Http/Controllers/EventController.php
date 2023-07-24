<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Event\EventRepositoryInterface;
use App\Utils\DateUtils;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index(Request $request)
    {
        $type = $request->get('type');
        $name = $request->get('name');
        $eventStart = $request->get('event_start');
        $eventEnd = $request->get('event_end');
        $events = $this->eventRepository->getAllByNameDateAndType($name, $eventStart, $eventEnd, $type);
        $filter = [
            'name' => $name,
            'event_start' => $eventStart,
            'event_end' => $eventEnd,
            'type' => $type,
        ];

        return view('event/index', [
            'events' => $events,
            'filter' => $filter,
        ]);
    }

    public function show(Event $event)
    {
        $interval = DateUtils::subtractStringDateTimes($event->event_start, $event->event_end);

        return view('event/detail', [
            'interval' => $interval,
            'event' => $event,
        ]);
    }
}
