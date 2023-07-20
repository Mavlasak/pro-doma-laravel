<?php

namespace App\Models\Event;

class EventRepository implements EventRepositoryInterface
{
    public function getAllOrders()
    {
        return Event::all();
    }
}
