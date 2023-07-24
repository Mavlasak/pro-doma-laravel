<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    public function delete(File $file)
    {
        Storage::delete(File::EVENT_FILE_UPLOAD_PATH . $file->event->id . '/' . $file->name);
        $file->delete();

        return redirect()->route('admin.event.edit', ['event' => $file->event])->with('danger', 'Soubor byl smazán.');
    }
}
