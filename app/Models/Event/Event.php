<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = json_encode($value);
    }

    public function getTypeAttribute($value)
    {
        return $this->attributes['type'] = json_decode($value);
    }
}
