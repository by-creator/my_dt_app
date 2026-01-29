<?php

namespace App\Services\Audit;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActivitiesExport;
use Spatie\Activitylog\Models\Activity;

class AuditExportB2Service
{
    protected string $disk = 'b2';

    public function storeAndClean(?string $from = null, ?string $to = null): array
    {
        DB::beginTransaction();

        try {
            /* ======================
             * 📁 Dossier journalier
             * ====================== */
            $folderDate = Carbon::now()->format('d-m-Y');
            $time = Carbon::now()->format('H-i-s');

            $basePath = "audit/{$folderDate}";
            Storage::disk($this->disk)->makeDirectory($basePath);

            /* ======================
             * 📊 EXCEL
             * ====================== */
            $excelName = "audit_logs_{$folderDate}_{$time}.xlsx";
            $excelPath = "{$basePath}/{$excelName}";

            Excel::store(
                new ActivitiesExport($from, $to),
                $excelPath,
                $this->disk
            );

            /* ======================
             * 📄 PDF
             * ====================== */
            $activities = Activity::with('causer')
                ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
                ->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to))
                ->latest()
                ->get();

            $pdf = Pdf::loadView('admin.audit.pdf', compact('activities'));

            $pdfName = "audit_logs_{$folderDate}_{$time}.pdf";
            $pdfPath = "{$basePath}/{$pdfName}";

            Storage::disk($this->disk)->put($pdfPath, $pdf->output());

            /* ======================
             * 🧹 NETTOYAGE BASE
             * ====================== */
            DB::table('activity_log')->truncate();

            DB::commit();

            Log::info('[AUDIT ARCHIVED & TRUNCATED]', compact(
                'excelPath',
                'pdfPath'
            ));

            return [
                'folder' => $basePath,
                'excel' => $excelPath,
                'pdf' => $pdfPath,
                'excel_url' => rtrim(config('filesystems.b2_public_url'), '/') . '/' . $excelPath,
                'pdf_url' => rtrim(config('filesystems.b2_public_url'), '/') . '/' . $pdfPath,
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('[AUDIT EXPORT FAILED]', [
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
