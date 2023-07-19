<?php

namespace App\Models\Event;

class EventRepository implements EventRepositoryInterface
{
    public function getAllOrders()
    {
        return Event::all();
    }

    public function getOrderById($orderId)
    {
        return Event::findOrFail($orderId);
    }

    public function deleteOrder($orderId)
    {
        Event::destroy($orderId);
    }

    public function createOrder(array $orderDetails)
    {
        return Event::create($orderDetails);
    }

    public function updateOrder($orderId, array $newDetails)
    {
        return Event::whereId($orderId)->update($newDetails);
    }

    public function getFulfilledOrders()
    {
        return Event::where('is_fulfilled', true);
    }
}
