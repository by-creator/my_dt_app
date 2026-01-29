<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivitiesCollectionExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected Collection $activities
    ) {}

    public function collection(): Collection
    {
        return $this->activities;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Utilisateur',
            'Action',
            'Rôle',
            'Méthode',
            'Route',
            'IP',
        ];
    }

    public function map($log): array
    {
        return [
            $log->created_at->format('d/m/Y H:i:s'),
            optional($log->causer)->email,
            $log->description,
            data_get($log->properties, 'role.name'),
            data_get($log->properties, 'method'),
            data_get($log->properties, 'route'),
            data_get($log->properties, 'ip'),
        ];
    }
}
