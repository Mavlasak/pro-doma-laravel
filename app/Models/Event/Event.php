<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function setTypeAttribute($value): void
    {
        $this->attributes['type'] = json_encode($value);
    }

    public function getTypeAttribute($value): array
    {
        return $this->attributes['type'] = json_decode($value);
    }
}
