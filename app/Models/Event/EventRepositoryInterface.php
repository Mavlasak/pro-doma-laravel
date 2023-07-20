<?php

namespace App\Models\Event;

interface EventRepositoryInterface
{
    public function getAllByNameDateAndType(?string $name, ?string $eventStart, ?string $eventEnd, ?string $type);
}
