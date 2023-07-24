<?php

namespace App\Models\Event;

use App\Models\File\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    public const ATTACHMENTS_UPLOAD_PATH = 'uploads/events/';

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

    public function createAndUploadFile(array $eventData, ?array $files): void
    {
        $filesData = [];
        try {
            DB::beginTransaction();
            $event = new Event();
            $event->fill($eventData)->save();
            if ($files) {
                $eventDirectory = self::ATTACHMENTS_UPLOAD_PATH . $event->id . '/';
                foreach($files as $file)
                {
                    $fileName = time() . rand(1,99) . '.' . $file->extension();
                    Storage::putFileAs($eventDirectory, $file, $fileName);
                    $filesData[]['name'] = $fileName;
                }
            }
            foreach ($filesData as $fileData) {
                $fileData['event_id'] = $event->id;
                $file = new File();
                $file->fill($fileData)->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($eventDirectory)) {
                Storage::deleteDirectory($eventDirectory);
            }
            throw $e;
        }
    }

    public function updateAndUploadFile(array $eventData, ?array $files): void
    {
        $filesData = [];
        try {
            DB::beginTransaction();
            $this->update($eventData);
            if ($files) {
                $eventDirectory = self::ATTACHMENTS_UPLOAD_PATH . $this->id . '/';
                foreach($files as $file)
                {
                    $fileName = time() . rand(1,99) . '.' . $file->extension();
                    Storage::putFileAs($eventDirectory, $file, $fileName);
                    $filesData[]['name'] = $fileName;
                }
            }
            foreach ($filesData as $fileData) {
                $fileData['event_id'] = $this->id;
                $file = new File();
                $file->fill($fileData)->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($eventDirectory)) {
                foreach ($filesData as $fileData) {
                    Storage::delete($eventDirectory . $fileData['name']);
                }
            }
            throw $e;
        }
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
