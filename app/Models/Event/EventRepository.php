<?php

namespace App\Models\Event;

class EventRepository implements EventRepositoryInterface
{
    public function getAllOrders()
    {
        return Event::all();
    }

    public function getEventById(int $eventId)
    {
        return Event::findOrFail($eventId);
    }

    public function deleteOrder($orderId)
    {
        Event::destroy($orderId);
    }

    public function createOrder(array $orderDetails)
    {
        return Event::create($orderDetails);
    }

    public function getFulfilledOrders()
    {
        return Event::where('is_fulfilled', true);
    }
}
