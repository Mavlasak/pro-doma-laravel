<?php

namespace App\Http\Controllers;

use App\Exceptions\File\FileAlreadyExistsException;
use App\Models\Event\Event;
use App\Models\Event\EventRepositoryInterface;
use App\Utils\BladeUtils;
use App\Utils\DateUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    private EventRepositoryInterface $eventRepository;

    private const EVENT_VALIDATE_RULES = [
        'event_start' => 'required|date',
        'event_end' => 'required|date|after:event_start',
        'type' => 'required',
        'participants_count' => 'required',
        'name' => 'required|unique:events|max:255',
    ];

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
        $events = $this->eventRepository->getAllByNameDateAndType($name, $eventStart, $eventEnd, $type[0] ?? null);
        $filter = [
            'name' => $name,
            'event_start' => $eventStart,
            'event_end' => $eventEnd,
        ];

        return view('event/index', [
            'events' => $events,
            'filter' => $filter,
            'eventTypes' => BladeUtils::setSelectedForSelect(Event::EVENT_TYPES, $type),
        ]);
    }

    public function new(Request $request)
    {
        return view('event/add-event-form', [
            'eventTypes' => BladeUtils::setSelectedForSelect(Event::EVENT_TYPES, $request->old('type')),
        ]);
    }

    public function store(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), self::EVENT_VALIDATE_RULES);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $event->createAndUploadFile($request->post(), $request->file('files'));
        } catch (FileAlreadyExistsException $exception) {
            return redirect()->route('event.new', [$event->id])->with('danger', 'Chyba při nahrávání souboru.');
        }

        return redirect()->route('event.index')->with('success', 'Událost byla přidána.');
    }

    public function show(Event $event)
    {
        $interval = DateUtils::subtractStringDateTimes($event->event_start, $event->event_end);

        return view('event/detail', [
            'interval' => $interval,
            'event' => $event,
        ]);
    }

    public function edit(Event $event)
    {
        return view('event/update-event-form', [
            'event' => $event,
            'eventTypes' => BladeUtils::setSelectedForSelect(Event::EVENT_TYPES, $event->type),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $rules = self::EVENT_VALIDATE_RULES;

        if ($event->name === $request->get('name')) {
            unset($rules['name']);
        }
        $request->validate($rules);
        $event->updateAndUploadFile($request->post(), $request->file('files'));

        return redirect()->route('event.edit', ['event' => $event])->with('success', 'Událost byla editována.');
    }

    public function delete(Event $event)
    {
        $event->delete();

        return redirect()->route('event.index')->with('success', 'Událost byla smazána.');
    }
}
