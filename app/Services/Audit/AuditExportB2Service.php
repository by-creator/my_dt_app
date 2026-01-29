<?php

namespace App\Services\Audit;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivitiesCollectionExport;
use Spatie\Activitylog\Models\Activity;

class AuditExportB2Service
{
    protected string $disk = 'b2';

    public function storeAndClean(?string $from = null, ?string $to = null): array
    {
        /* ======================
         * 1️⃣ FIGER LES DONNÉES
         * ====================== */
        $activities = Activity::with('causer')
            ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to))
            ->latest()
            ->get();

        if ($activities->isEmpty()) {
            throw new \RuntimeException('Aucune donnée à archiver.');
        }

        /* ======================
         * 2️⃣ DOSSIER
         * ====================== */
        $folderDate = Carbon::now()->format('d-m-Y');
        $time = Carbon::now()->format('H-i-s');
        $basePath = "audit/{$folderDate}";

        Storage::disk($this->disk)->makeDirectory($basePath);

        /* ======================
         * 3️⃣ EXCEL (SUR COLLECTION)
         * ====================== */
        $excelPath = "{$basePath}/audit_logs_{$folderDate}_{$time}.xlsx";

        Excel::store(
            new ActivitiesCollectionExport($activities),
            $excelPath,
            $this->disk
        );

        /* ======================
         * 4️⃣ PDF (SUR LA MÊME COLLECTION)
         * ====================== */
        $pdf = Pdf::loadView('admin.audit.pdf', [
            'activities' => $activities
        ]);

        $pdfPath = "{$basePath}/audit_logs_{$folderDate}_{$time}.pdf";

        Storage::disk($this->disk)->put($pdfPath, $pdf->output());

        /* ======================
         * 5️⃣ VÉRIFICATION B2
         * ====================== */
        if (
            !Storage::disk($this->disk)->exists($excelPath) ||
            !Storage::disk($this->disk)->exists($pdfPath)
        ) {
            throw new \RuntimeException('Échec stockage B2.');
        }

        /* ======================
         * 6️⃣ NETTOYAGE (APRÈS)
         * ====================== */
        DB::table('activity_log')->truncate();

        Log::info('[AUDIT ARCHIVED & CLEANED]', compact('excelPath', 'pdfPath'));

        return [
            'excel' => $excelPath,
            'pdf' => $pdfPath,
        ];
    }
}
