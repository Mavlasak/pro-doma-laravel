<?php

namespace App\Models\File;

use App\Models\Event\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    protected $fillable = ['name', 'event_id'];

    use HasFactory;

    public function Event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
