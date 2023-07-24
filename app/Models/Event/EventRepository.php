<?php

namespace App\Models\Event;

use App\Models\Event;

class EventRepository implements EventRepositoryInterface
{
    public function getAllByNameDateAndType(?string $name, ?string $eventStart, ?string $eventEnd, ?string $type)
    {
        $query = Event::where('name','LIKE','%' . ($name === null ? '' : '%' . $name) . '%');
        if ($eventStart !== null) {
            $query->where('event_start', '>=', date($eventStart));
        }
        if ($eventEnd !== null) {
            $query->where('event_end', '<=', date($eventEnd));
        }

        if ($type !== null) {
            $query->where('type', '=', $type);
        }
        return $query->orderBy('name')->get();
    }
}
