<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Event\EventRepositoryInterface;
use App\Utils\BladeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    private EventRepositoryInterface $eventRepository;

    private const EVENT_VALIDATE_RULES = [
        'event_start' => 'required|date',
        'event_end' => 'required|date|after:event_start',
        'type' => 'required',
        'action_type' => 'required',
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
        $events = $this->eventRepository->getAllByNameDateAndType($name, $eventStart, $eventEnd, $type);
        $filter = [
            'name' => $name,
            'event_start' => $eventStart,
            'event_end' => $eventEnd,
            'type' => $type,
        ];

        return view('admin/event/index', [
            'events' => $events,
            'filter' => $filter,
        ]);
    }

    public function edit(Event $event)
    {
        return view('admin/event/update-event-form', [
            'event' => $event,
            'eventActionTypes' => BladeUtils::setCheckedForCheckbox(Event::EVENT_ACTION_TYPES, $event->action_type),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $rules = self::EVENT_VALIDATE_RULES;

        if ($event->name === $request->get('name')) {
            unset($rules['name']);
        }
        $request->validate($rules);
        try {
            $event->updateAndUploadFile($request->post(), $request->file('files'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('danger', 'Došlo k chybě.');
        }

        return redirect()->route('admin.event.edit', ['event' => $event])->with('success', 'Událost byla editována.');
    }

    public function delete(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.event.index')->with('success', 'Událost byla smazána.');
    }

    public function new(Request $request)
    {
        return view('admin/event/add-event-form', [
            'eventActionTypes' => BladeUtils::setCheckedForCheckbox(Event::EVENT_ACTION_TYPES, $request->old('action_type')),
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
        } catch (\Exception $exception) {
            return redirect()->back()->with('danger', 'Došlo k chybě.')->withInput();
        }

        return redirect()->route('admin.event.index')->with('success', 'Událost byla přidána.');
    }
}
