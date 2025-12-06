<?php

namespace App\Http\Controllers;

use App\Mail\ProformaGenerateMail;
use App\Models\DossierFacturation;
use App\Models\RattachementBl;
use App\Models\User;
use Illuminate\Http\Request;


class DossierFacturationController extends Controller
{

    public function index()
    {
        return view('dossier_facturation.form');
    }

    public function indexValidation()
    {
        return view('dossier_facturation.validation');
    }

    public function indexPaiement()
    {
        return view('dossier_facturation.paiement');
    }

    public function indexTutoVideo()
    {
        $videos = [
            [
                'title' => 'Étape 1 : Validation',
                'description' => 'Commment envoyer une demande de validation ?',
                'image' => null,
                'link' => asset('templates/site/video/validation.mp4'),
            ],
            [
                'title' => 'Étape 2 : Proforma',
                'description' => 'Commment avoir sa facture proforma ?',
                'image' => null,
                'link' => asset('templates/site/video/proforma.mp4'),
            ],
            [
                'title' => 'Étape 3 : Facture définitive',
                'description' => 'Commment avoir sa facture définitive ?',
                'image' => null,
                'link' => asset('templates/site/video/facture.mp4'),
            ],
            [
                'title' => 'Étape 4 : Paiement',
                'description' => 'Commment payer sa facture définitive ?',
                'image' => null,
                'link' => '#',
                'id'=> 'videoPaiement'
            ],
            [
                'title' => 'Étape 5 : BAD',
                'description' => 'Commment avoir son  BAD ?',
                'image' => null,
                'link' => asset('templates/site/video/bad.mp4'),
            ],
            [
                'title' => 'Étape 6 : Facture complémentaire',
                'description' => 'Commment avoir sa facture complémentaire ?',
                'image' => null,
                'link' => asset('templates/site/video/complement.mp4'),
            ],
            [
                'title' => 'Étape 7 : Demande de réduction',
                'description' => 'Commment faire une demande de réduction ?',
                'image' => null,
                'link' => '#',
                'id'=> 'videoReduction'
            ],
        ];

        return view('dossier_facturation.tuto_video', compact('videos'));
    }

    public function indexTutoPdf()
    {
        $pdfs = [
            [
                'title' => 'Étape 1 : Validation',
                'description' => 'Commment envoyer une demande de validation ?',
                'image' => null,
                'link' => '#'
            ],
            [
                'title' => 'Étape 2 : Proforma',
                'description' => 'Commment avoir sa facture proforma ?',
                'image' => null,
                'link' => '#'
            ],
            [
                'title' => 'Étape 3 : Facture définitive',
                'description' => 'Commment avoir sa facture définitive ?',
                'image' => null,
                'link' => '#'
            ],
            [
                'title' => 'Étape 4 : Paiement',
                'description' => 'Commment payer sa facture définitive ?',
                'image' => null,
                'link' => '#'
            ],
            [
                'title' => 'Étape 5 : BAD',
                'description' => 'Commment avoir son  BAD ?',
                'image' => null,
                'link' => '#'
            ],
            [
                'title' => 'Étape 6 : Facture complémentaire',
                'description' => 'Commment avoir sa facture complémentaire ?',
                'image' => null,
                'link' => '#'
            ],
            [
                'title' => 'Étape 7 : Demande de réduction',
                'description' => 'Commment faire une demande de réduction ?',
                'image' => null,
                'link' => '#'
            ],
        ];

        return view('dossier_facturation.tuto_pdf', compact('pdfs'));
    }



    public function show(DossierFacturation $dossier)
    {
        return view('dossier_facturation.show', compact('dossier'));
    }

    public function list()
    {
        $dossiers = DossierFacturation::orderBy('created_at', 'desc')->get();
        return view('dossier_facturation.list', compact('dossiers'));
    }

    public function store(Request $request)
    {
        $fields = ['proforma', 'facture', 'bon'];

        $validated = $request->validate([
            'proforma.*' => 'nullable|mimes:pdf|max:2048',
            'facture.*' => 'nullable|mimes:pdf|max:2048',
            'bon.*' => 'nullable|mimes:pdf|max:2048',
            'date_proforma' => 'nullable|date',
        ]);

        $saveData = [
            'date_proforma' => $request->date_proforma,
        ];

        foreach ($fields as $field) {
            $saveData[$field] = [];

            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $file) {
                    $path = $file->store("documents/$field", 'b2'); // B2 disk

                    if ($path) {
                        $saveData[$field][] = [
                            'original' => $file->getClientOriginalName(),
                            'path' => $path,
                        ];
                    }
                }
            }
        }

        DossierFacturation::create($saveData);

        return back()->with('success', 'Documents enregistrés avec succès !');
    }

    public function facture()
    {
        return view('dossier_facturation.facture');
    }

    public function bon()
    {

        return view('dossier_facturation.bon');
    }
}
