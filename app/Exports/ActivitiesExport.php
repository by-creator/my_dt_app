<?php

namespace App\Exports;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivitiesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $from;
    protected $to;

    public function __construct($from = null, $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection(): Collection
    {
        $query = Activity::with('causer')->latest();

        if ($this->from) {
            $query->whereDate('created_at', '>=', $this->from);
        }

        if ($this->to) {
            $query->whereDate('created_at', '<=', $this->to);
        }

        return $query->get();
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
