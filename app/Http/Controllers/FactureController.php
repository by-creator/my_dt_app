<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|max:5120', // 5 MB max
        ]);

        $file = $request->file('file');

        Facture::create([
            'title' => $request->title,
            'filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_data' => file_get_contents($file->getRealPath()),
        ]);

        return response()->json(['message' => 'Document enregistré dans la base de données ✅']);
    }

    public function view($id)
    {
        $document = Facture::findOrFail($id);

        return response($document->file_data)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $document->filename . '"');
    }

    public function download($id)
    {
        $document = Facture::findOrFail($id);

        return response($document->file_data)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $document->filename . '"');
    }
}
