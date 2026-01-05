<?php

namespace App\Services\Dossier;

class TutorialService
{
    public function videos(): array
    {
        return [
            [
                'title' => 'Étape 1 : Validation',
                'description' => 'Commment envoyer une demande de validation ?',
                'link' => asset('templates/site/video/validation.mp4'),
            ],
            [
                'title' => 'Étape 2 : Proforma',
                'description' => 'Commment avoir sa facture proforma ?',
                'link' => asset('templates/site/video/proforma.mp4'),
            ],
            [
                'title' => 'Étape 3 : Facture définitive',
                'description' => 'Commment avoir sa facture définitive ?',
                'link' => asset('templates/site/video/facture.mp4'),
            ],
            [
                'title' => 'Étape 5 : BAD',
                'description' => 'Commment avoir son BAD ?',
                'link' => asset('templates/site/video/bad.mp4'),
            ],
            [
                'title' => 'Étape 6 : Facture complémentaire',
                'description' => 'Commment avoir sa facture complémentaire ?',
                'link' => asset('templates/site/video/complement.mp4'),
            ],
        ];
    }

    public function pdfs(): array
    {
        return [
            ['title' => 'Étape 1 : Validation'],
            ['title' => 'Étape 2 : Proforma'],
            ['title' => 'Étape 3 : Facture définitive'],
            ['title' => 'Étape 4 : Paiement'],
            ['title' => 'Étape 5 : BAD'],
            ['title' => 'Étape 6 : Facture complémentaire'],
        ];
    }
}
