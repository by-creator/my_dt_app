<?php

namespace App\Http\Controllers;

use App\Exports\TiersIpakiExport;
use App\Imports\TiersIpakiImport;
use Illuminate\Http\Request;
use App\Models\TiersIpaki;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class IpakiController extends Controller
{

    public function create(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'accounting_id' => 'required|string|max:255',

        ]);

        TiersIpaki::create($data);

        return redirect()->route('ipaki.admin')->with('create', 'Tiers ipaki créé avec succès.');
    }
    
    public function list()
    {
        $tiers = TiersIpaki::orderBy('id', 'desc')->get();
        return view('unify.list', compact('tiers'));
    }

    public function update(Request $request, $id)
    {
        $tiers = TiersIpaki::findOrFail($id);

        $tiers->code = $request->code;
        $tiers->label = $request->label;
        $tiers->active = $request->active;
        $tiers->billable = $request->billable;
        $tiers->accounting_id = $request->accounting_id;
        
        $tiers->save();

        return redirect()->route('ipaki.admin')->with('update', 'Tiers ipaki mis à jour avec succès.');
    }

    public function delete($id)
    {
        $user = TiersIpaki::findOrFail($id);
        $user->delete();

        return redirect()->route('ipaki.admin')->with('delete', 'Tiers ipaki supprimé avec succès.');
    }

    public function admin()
    {
        $tiers = TiersIpaki::orderBy('id', 'desc')->get();
        if(Auth::user()->role_id == 1)
        {
            return view('unify.admin', compact('tiers'));
        }
        else
        {
            return redirect()->back()->with('error', 'Vous ne disposez pas des droits requis pour effectuer cette action !');
        }
        
    }

    public function form(Request $request)
    {
        $action = $request->input('submit');

        if ($action === 'import') {

            return $this->import($request);
        }
        if ($action === 'filter') {

            return $this->filter($request);
        }
        return redirect()->back()->withErrors('Action inconnue.');

    }

    public function export()
    {
        return Excel::download(new TiersIpakiExport, 'tiers-ipaki.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new TiersIpakiImport, $request->file('file'));

        return redirect()->back()->with('import', 'Importation des tiers réussie.');
    }

    public function truncate()
    {
        DB::table('tiers_ipakis')->truncate();

        return redirect()->back()->with('truncate', 'Table tiers_ipakis tronquée avec succès.');
    }

    public function filter(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        // Étape 1 : Lire le fichier
        [$header, $rows] = $this->readExcel($request->file('file'));

        // Étape 2 : Filtrer et trier
        $sortedRows = $this->filterAndSort($rows);

        // Étape 3 : Générer un nouveau fichier Excel
        $filePath = $this->generateExcel($header, $sortedRows);

        // Étape 4 : Retourner le fichier en téléchargement
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    private function readExcel($file): array
    {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        $header = array_shift($sheet); // 1re ligne = en-tête
        return [$header, collect($sheet)];
    }

    private function filterAndSort(Collection $rows): Collection
    {
        return $rows
            ->filter(fn($row) => isset($row[0]) && preg_match('/^\d+$/', $row[0]))
            ->sortBy(fn($row) => (int) $row[0])
            ->values();
    }

    private function generateExcel(array $header, Collection $rows): string
    {
        $data = collect([$header])->merge($rows);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray($data->toArray());

        $fileName = 'fichier_trie.xlsx';
        $filePath = storage_path($fileName);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $filePath;
    }
}
