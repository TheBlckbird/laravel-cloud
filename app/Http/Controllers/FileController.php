<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index($directory = '')
    {
        if (!Storage::exists($directory)) {
            return redirect('/');
        }

        return view('index', [
            'directories' => Storage::directories($directory),
            'files' => Storage::files($directory),
            'path' => $directory,
        ]);
    }

    public function download($file) {
        return Storage::download($file);
    }

    public function newFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $file = $request->file('file');
        $file->storeAs($request->path, trim($file->getClientOriginalName()));

        return back();
    }

    public function newDirectory(Request $request)
    {
        $request->validate([
            'directory_name' => 'required|max:255|string'
        ]);

        $directory = $request->path != '' ? $request->path . '/' . $request->directory_name : $request->directory_name;
        Storage::makeDirectory($directory);

        return back();
    }
}
