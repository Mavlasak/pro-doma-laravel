<?php

namespace App\Http\Controllers;

use App\Models\Event\Event;
use App\Models\Event\EventRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->eventRepository->getAllOrders()
        ]);
    }

    public function new()
    {
        return view('Event/add-event-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:events|max:255',
            'event_start' => 'required|date',
            'event_end' => 'required|date|after:event_start',
            'type' => 'required',
            'participants_count' => 'required',
        ]);

        $event = new Event();
        $event->name = $request->name;
        $event->event_start = $request->event_start;
        $event->event_end = $request->event_end;
        $event->type = $request->type;
        $event->note = $request->note;
        $event->attachment = $request->attachment;
        $event->participants_count = $request->participants_count;
        $event->save();

        return redirect()->route('event.index')->with('success', 'Událost byla přidána.');
    }

    public function show(Request $request): JsonResponse
    {
        $orderId = $request->route('id');

        return response()->json([
            'data' => $this->eventRepository->getOrderById($orderId)
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $orderId = $request->route('id');
        $orderDetails = $request->only([
            'client',
            'details'
        ]);

        return response()->json([
            'data' => $this->eventRepository->updateOrder($orderId, $orderDetails)
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $orderId = $request->route('id');
        $this->eventRepository->deleteOrder($orderId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
