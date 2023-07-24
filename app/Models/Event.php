<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $fillable = ['name', 'event_start', 'event_end', 'action_type', 'type', 'note', 'attachment', 'participants_count'];

    public const EVENT_ACTION_TYPES = [
        'php' => 'PHP',
        'angular' => 'Angular',
        'javascript' => 'Javascript',
        'vue' => 'Vue',
        'react' => 'React',
        'jquery' => 'JQuery',
    ];

    public const EVENT_TYPES = [
        'typ_1' => 'TYP 1',
        'typ_2' => 'TYP 2',
        'typ_3' => 'TYP 3',
        'typ_4' => 'TYP 4',
        'typ_5' => 'TYP 5',
    ];

    use HasFactory;

    public function setActionTypeAttribute($value): void
    {
        $this->attributes['action_type'] = json_encode($value);
    }

    public function getActionTypeAttribute($value): array
    {
        return $this->attributes['action_type'] = json_decode($value);
    }

    public function createAndUploadFile(array $eventData, ?array $files): void
    {
        try {
            DB::beginTransaction();
            $event = new Event();
            $event->fill($eventData)->save();
            if ($files) {
                $eventDirectory = File::EVENT_FILE_UPLOAD_PATH . $event->id . '/';
                foreach($files as $file)
                {
                    $fileName = time() . rand(1,99) . '.' . $file->extension();
                    Storage::putFileAs($eventDirectory, $file, $fileName);
                    $fileData = [
                        'event_id' => $event->id,
                        'name' => $fileName,
                    ];
                    $file = new File();
                    $file->fill($fileData)->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            if (isset($eventDirectory)) {
                Storage::deleteDirectory($eventDirectory);
            }
            DB::rollBack();
            throw $e;
        }
    }

    public function updateAndUploadFile(array $eventData, ?array $files): void
    {
        $filesData = [];
        try {
            $eventDirectory = File::EVENT_FILE_UPLOAD_PATH . $this->id . '/';
            DB::beginTransaction();
            $this->update($eventData);
            if ($files) {
                foreach($files as $file)
                {
                    $fileName = time() . rand(1,99) . '.' . $file->extension();
                    Storage::putFileAs($eventDirectory, $file, $fileName);
                    $filesData[$this->id] = [
                        'event_id' => $this->id,
                        'name' => $fileName,
                    ];
                    $file = new File();
                    $file->fill($filesData[$this->id])->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            foreach ($filesData as $fileData) {
                Storage::delete($eventDirectory . $fileData['name']);
            }
            DB::rollBack();
            throw $e;
        }
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
