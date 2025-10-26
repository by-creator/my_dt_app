<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


use App\Models\Proforma;
use Illuminate\Http\Request;

class ProformaController extends Controller
{
    public function store(Request $request)
    {
         $request->validate([
            'bl' => 'nullable|string|max:255',
            'account' => 'nullable|string|max:255',
            'files.*' => 'required|file|max:5120', // max 5 Mo par fichier
        ]);


        $uploadedDocuments = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $uploadedDocuments[] = Proforma::create([
                    'user_id' => Auth::user()->id,
                    'bl' => $request->bl,
                    'account' => $request->account,
                    'document' => $file->getClientOriginalName(),
                    'filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'file_data' => file_get_contents($file->getRealPath()),
                ]);
            }
        }

        return response()->json([
            'message' => 'Documents enregistrés avec succès ✅',
            'documents' => $uploadedDocuments,
        ]);
    }

    public function update(Request $request, Proforma $proforma)
    {
        $request->validate([
            'bl' => 'required|string|max:255',
            'account' => 'required|string|max:255',
            'document' => 'required|file|max:5120', // 5 MB max
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $proforma->filename = $file->getClientOriginalName();
            $proforma->mime_type = $file->getMimeType();
            $proforma->file_data = file_get_contents($file->getRealPath());
        }

        $proforma->save();

        return response()->json(['message' => 'Document mis à jour avec succès']);
    }

   // Visualiser un document
    public function view($id)
    {
        $document = Proforma::findOrFail($id);
        return response($document->file_data)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $document->filename . '"');
    }

    // Télécharger un document
    public function download($id)
    {
        $document = Proforma::findOrFail($id);
        return response($document->file_data)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $document->filename . '"');
    }
}
