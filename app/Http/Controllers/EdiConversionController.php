<?php

namespace App\Http\Controllers;

use App\Services\EdiParser;
use App\Services\EdiExporter;
use App\Services\XlsxExporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EdiConversionController extends Controller
{
    public function __construct(
        private readonly EdiParser   $parser,
        private readonly EdiExporter $exporter,
        private readonly XlsxExporter $xlsxExporter,
    ) {}

    public function index()
    {
        return view('edi.index');
    }

    /**
     * Parse le fichier TXT, stocke temporairement et affiche l'aperçu.
     */
    public function preview(Request $request)
    {
        $request->validate([
            'edi_file' => ['required', 'file', 'mimes:txt,text', 'max:51200'],
        ], [
            'edi_file.required' => 'Veuillez sélectionner un fichier TXT.',
            'edi_file.mimes'    => 'Le fichier doit être au format .txt.',
            'edi_file.max'      => 'Le fichier ne doit pas dépasser 50 Mo.',
        ]);

        try {
            $uploadedFile = $request->file('edi_file');
            $records      = $this->parser->parse($uploadedFile->getRealPath());

            if ($records->isEmpty()) {
                return back()->withInput()
                    ->withErrors(['edi_file' => 'Aucun enregistrement valide trouvé dans le fichier.']);
            }

            $token  = Str::random(32);
            $tmpDir = storage_path('app/edi_tmp');
            if (! is_dir($tmpDir)) mkdir($tmpDir, 0755, true);

            $tmpTxtPath = "{$tmpDir}/{$token}.txt";
            copy($uploadedFile->getRealPath(), $tmpTxtPath);

            session([
                "edi_preview_{$token}" => [
                    'original_name' => $uploadedFile->getClientOriginalName(),
                    'txt_path'      => $tmpTxtPath,
                    'record_count'  => $records->count(),
                    'expires_at'    => now()->addMinutes(30)->timestamp,
                ],
            ]);

            $headers     = $this->parser->getHeaders();
            $previewRows = $records;
            $totalCount  = $records->count();

            return view('edi.preview', compact('previewRows', 'headers', 'token', 'totalCount'));
        } catch (\Throwable $e) {
            Log::error('EDI preview failed', ['message' => $e->getMessage()]);
            return back()->withInput()
                ->withErrors(['edi_file' => 'Erreur lors de la lecture : ' . $e->getMessage()]);
        }
    }

    /**
     * Génère et télécharge le fichier .edi depuis le TXT stocké.
     */
    public function download(string $token)
    {
        $sessionKey = "edi_preview_{$token}";
        $meta       = session($sessionKey);

        if (! $meta || now()->timestamp > $meta['expires_at']) {
            return redirect()->route('edi.index')
                ->withErrors(['edi_file' => 'Session expirée. Veuillez ré-uploader votre fichier.']);
        }

        if (! file_exists($meta['txt_path'])) {
            return redirect()->route('edi.index')
                ->withErrors(['edi_file' => 'Fichier temporaire introuvable. Veuillez ré-uploader.']);
        }

        try {
            $records      = $this->parser->parse($meta['txt_path']);
            $originalName = pathinfo($meta['original_name'], PATHINFO_FILENAME);
            $outputName   = Str::slug($originalName) . '_' . now()->format('Ymd_His') . '.edi';
            $outputPath   = storage_path("app/edi_tmp/{$outputName}");

            $this->exporter->export($records, $outputPath);

            @unlink($meta['txt_path']);
            session()->forget($sessionKey);

            return response()->download($outputPath, $outputName, [
                'Content-Type' => 'application/edifact',
            ])->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            Log::error('EDI download failed', ['message' => $e->getMessage()]);
            return redirect()->route('edi.index')
                ->withErrors(['edi_file' => 'Erreur lors de la conversion : ' . $e->getMessage()]);
        }
    }

    public function downloadXlsx(string $token)
    {
        $sessionKey = "edi_preview_{$token}";
        $meta       = session($sessionKey);

        if (! $meta || now()->timestamp > $meta['expires_at']) {
            return redirect()->route('edi.index')
                ->withErrors(['edi_file' => 'Session expirée. Veuillez ré-uploader votre fichier.']);
        }

        if (! file_exists($meta['txt_path'])) {
            return redirect()->route('edi.index')
                ->withErrors(['edi_file' => 'Fichier temporaire introuvable. Veuillez ré-uploader.']);
        }

        try {
            $records      = $this->parser->parse($meta['txt_path']);
            $originalName = pathinfo($meta['original_name'], PATHINFO_FILENAME);
            $outputName   = Str::slug($originalName) . '_' . now()->format('Ymd_His') . '.xlsx';
            $outputPath   = storage_path("app/edi_tmp/{$outputName}");

            $headers = $this->parser->getHeaders();
            $this->xlsxExporter->export($records, $headers, $outputPath);

            return response()->download($outputPath, $outputName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            Log::error('XLSX download failed', ['message' => $e->getMessage()]);
            return redirect()->route('edi.index')
                ->withErrors(['edi_file' => 'Erreur lors de la conversion : ' . $e->getMessage()]);
        }
    }

    /**
     * API endpoint — POST /api/edi/convert
     */
    public function apiConvert(Request $request)
    {
        $request->validate([
            'edi_file' => 'required|file|mimes:txt,text|max:51200',
        ]);

        try {
            $records = $this->parser->parse($request->file('edi_file')->getRealPath());

            if ($records->isEmpty()) {
                return response()->json(['error' => 'No valid records found.'], 422);
            }

            $tmpDir = storage_path('app/edi_tmp');
            if (! is_dir($tmpDir)) mkdir($tmpDir, 0755, true);

            $outputPath = "{$tmpDir}/api_" . Str::random(10) . '.edi';
            $this->exporter->export($records, $outputPath);

            return response()->download($outputPath, 'output.edi', [
                'Content-Type' => 'application/edifact',
            ])->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
