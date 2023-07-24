<?php

namespace App\Http\Controllers;

use App\Models\Event\Event;
use App\Models\File\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FilesystemException;

class FileController extends Controller
{
    public function download(File $file)
    {
        try {
            return Storage::download(Event::ATTACHMENTS_UPLOAD_PATH . $file->event->id . '/' . $file->name);
        } catch (FilesystemException $exception) {
            return redirect()->route('event.index')->with('danger', 'Soubor neexistuje.');
        }
    }

    public function delete(File $file)
    {
        $file->delete();

        return redirect()->route('event.edit', ['event' => $file->event])->with('danger', 'Soubor byla smazán.');
    }
}
