<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait ConvertsDates
{
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->getDates()) && $value) {

            // Liste des formats possibles (ajuste selon ton CSV)
            $formats = [
                'd/m/Y H:i:s',
                'd/m/Y H:i',
                'd/m/Y',
                'Y-m-d H:i:s',
                'Y-m-d',
                'd-m-Y H:i:s',
                'd-m-Y H:i',
                'd-m-Y',
            ];

            $converted = null;

            foreach ($formats as $format) {
                try {
                    $converted = Carbon::createFromFormat($format, trim($value));
                    break; // si la conversion réussit, on sort de la boucle
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Si aucun format ne correspond, on tente une détection automatique
            if (!$converted) {
                try {
                    $converted = Carbon::parse($value);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("Format de date invalide pour [$key]: $value");

                    $converted = null;
                }
            }

            // On reformate pour l’enregistrement dans la base
            if ($converted) {
                $value = $converted->format('Y-m-d H:i:s');
            } else {
                $value = null; // ou garde la valeur brute si tu préfères
            }

        }

        return parent::setAttribute($key, $value);
    }
}
