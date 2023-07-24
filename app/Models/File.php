<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    public const EVENT_FILE_UPLOAD_PATH = 'uploads/events/';

    protected $fillable = ['name', 'event_id'];

    use HasFactory;

    public function Event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
