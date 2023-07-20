<?php

namespace App\Http\Controllers;

use App\Models\Event\Event;
use App\Models\Event\EventRepositoryInterface;
use App\Utils\BladeUtils;
use App\Utils\DateUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index(Request $request)
    {
        $type = $request->get('type') === null ? null : $request->get('type')[0];
        $name = $request->get('name');
        $eventStart = $request->get('event_start');
        $eventEnd = $request->get('event_end');
        $events = $this->eventRepository->getAllByNameDateAndType($name, $eventStart, $eventEnd, $type);
        $filter = [
            'name' => $name,
            'event_start' => $eventStart,
            'event_end' => $eventEnd,
        ];

        return view('Event/index', [
            'events' => $events,
            'filter' => $filter,
            'eventTypes' => BladeUtils::setSelectedForSelect(Event::EVENT_TYPES, [$type]),
        ]);
    }

    public function new(Request $request)
    {
        return view('Event/add-event-form', [
            'eventTypes' => BladeUtils::setSelectedForSelect(Event::EVENT_TYPES, $request->old('type')),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:events|max:255',
            'event_start' => 'required|date',
            'event_end' => 'required|date|after:event_start',
            'type' => 'required',
            'participants_count' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $event = new Event;
        $event->fill($request->post())->save();

        return redirect()->route('event.index')->with('success', 'Událost byla přidána.');
    }

    public function show(Event $event)
    {
        $interval = DateUtils::subtractStringDateTimes($event->event_start, $event->event_end);

        return view('Event/event-detail', [
            'interval' => $interval,
            'event' => $event,
        ]);
    }

    public function edit(Event $event)
    {
        return view('Event/update-event-form', [
            'event' => $event,
            'eventTypes' => BladeUtils::setSelectedForSelect(Event::EVENT_TYPES, $event->type),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validateRules = [
            'event_start' => 'required|date',
            'event_end' => 'required|date|after:event_start',
            'type' => 'required',
            'participants_count' => 'required'];

        if ($event->name === $request->route('name')) {
            $validateRules['name'] = 'required|unique:events|max:255';
        }
        $request->validate($validateRules);
        $event->fill($request->post())->save();

        return redirect()->route('event.edit', ['event' => $event])->with('success', 'Událost byla editována.');
    }

    public function delete(Event $event)
    {
        $event->delete();

        return redirect()->route('event.index')->with('success', 'Událost byla smazána.');
    }
}
