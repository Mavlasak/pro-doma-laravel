<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FilesystemException;

class FileController extends Controller
{
    public function download(File $file)
    {
        try {
            return Storage::download(File::EVENT_FILE_UPLOAD_PATH . $file->event->id . '/' . $file->name);
        } catch (FilesystemException $exception) {
            return redirect()->route('event.index')->with('danger', 'Soubor neexistuje.');
        }
    }
}
