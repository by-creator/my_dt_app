<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;


class StatsExport implements FromArray
{
    protected $stats;

    public function __construct(array $stats)
    {
        $this->stats = $stats;
    }
    public function array(): array
    {
        $data = [[]];
        foreach ($this->stats as $key => $count) {
            [$typeTc, $sens, $statut] = explode('|', $key);
            $data[] = [$typeTc, $sens, $statut, $count];
        }
        return $data;
    }
}
