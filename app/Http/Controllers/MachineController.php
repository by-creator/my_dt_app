<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\MachinesImport;
use App\Exports\MachinesExport;
use App\Models\Machine;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MachineController extends Controller
{
    public function index()
    {
        $machines = Machine::orderBy('id', 'desc')->get();
        $user = Auth::user();
        return view('machines.index', compact('machines', 'user'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'numero_serie' => 'nullable|string|max:255',
            'modele'       => 'nullable|string|max:255',
            'type'         => 'nullable|string|max:255',
            'utilisateur'  => 'nullable|string|max:255',
            'service'      => 'nullable|string|max:255',
            'site'         => 'nullable|string|max:255',
        ]);

        Machine::create($data);

        return redirect()->back()->with('create', 'Machine créée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $machine = Machine::findOrFail($id);

        $machine->numero_serie = $request->numero_serie;
        $machine->modele       = $request->modele;
        $machine->type         = $request->type;
        $machine->utilisateur  = $request->utilisateur;
        $machine->service      = $request->service;
        $machine->site         = $request->site;

        $machine->save();

        return redirect()->back()->with('update', 'Machine mise à jour avec succès.');
    }

    public function delete($id)
    {
        $machine = Machine::findOrFail($id);
        $machine->delete();

        return redirect()->back()->with('delete', 'Machine supprimée avec succès.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,txt',
        ]);

        Excel::import(new MachinesImport, $request->file('file'));

        return redirect()->back()->with('success', 'Machines importées avec succès.');
    }

    public function export()
    {
        $fileName = 'machines_' . now()->format('Ymd_His') . '.csv';
        return Excel::download(new MachinesExport, $fileName);
    }
}
