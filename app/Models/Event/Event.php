<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'event_start', 'event_end', 'type', 'note', 'attachment', 'participants_count'];

    public const EVENT_TYPES = [
        'php' => 'PHP',
        'angular' => 'Angular',
        'javascript' => 'Javascript',
        'vue' => 'Vue',
        'react' => 'React',
        'jquery' => 'JQuery',
    ];

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
