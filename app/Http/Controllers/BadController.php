<?php

namespace App\Http\Controllers;

use App\Models\Bad;
use Illuminate\Http\Request;

class BadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|max:5120', // 5 MB max
        ]);

        $file = $request->file('file');

        Bad::create([
            'title' => $request->title,
            'filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_data' => file_get_contents($file->getRealPath()),
        ]);

        return response()->json(['message' => 'Document enregistré dans la base de données ✅']);
    }

    public function view($id)
    {
        $document = Bad::findOrFail($id);

        return response($document->file_data)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $document->filename . '"');
    }

    public function download($id)
    {
        $document = Bad::findOrFail($id);

        return response($document->file_data)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $document->filename . '"');
    }
}
