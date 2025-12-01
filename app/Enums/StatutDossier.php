<?php

namespace App\Enums;

enum StatutDossier: string
{

    
    case EN_ATTENTE_VALIDATION = 'EN ATTENTE VALIDATION';
    case VALIDE = 'VALIDE';
    case EN_ATTENTE_PROFORMA = 'EN ATTENTE PROFORMA';
    case EN_ATTENTE_PROFORMA_RELANCE   = 'EN ATTENTE PROFORMA RELANCE';
    case PROFORMA_VALIDE   = 'PROFORMA VALIDE';
    case EN_ATTENTE_FACTURE    = 'EN ATTENTE FACTURE';
    case EN_ATTENTE_FACTURE_RELANCE     = 'EN ATTENTE FACTURE RELANCE';
    case EN_ATTENTE_BAD     = 'EN ATTENTE BAD';
    case EN_ATTENTE_BAD_RELANCE     = 'EN ATTENTE BAD RELANCE';

    // Optionnel : pour afficher un label lisible
    public function label(): string
    {
        return match ($this) {
            self::EN_ATTENTE_VALIDATION => 'EN ATTENTE VALIDATION',
            self::VALIDE => 'VALIDE',
            self::EN_ATTENTE_PROFORMA => 'EN ATTENTE PROFORMA',
            self::EN_ATTENTE_PROFORMA_RELANCE   => 'EN ATTENTE PROFORMA RELANCE',
            self::EN_ATTENTE_FACTURE    => 'EN ATTENTE FACTURE',
            self::EN_ATTENTE_FACTURE_RELANCE     => 'EN ATTENTE FACTURE RELANCE',
            self::EN_ATTENTE_BAD     => 'EN ATTENTE BAD',
            self::EN_ATTENTE_BAD_RELANCE     => 'EN ATTENTE BAD RELANCE',
        };
    }
}
