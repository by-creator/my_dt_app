<?php

namespace App\Http\Controllers;

use App\Models\TelephoneMobile;
use App\Imports\TelephoneMobileImport;
use App\Exports\TelephoneMobileExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;


class TelephoneMobileController extends Controller
{
    /**
     * 📄 Liste
     */
     public function index(Request $request)
    {
         $user = Auth::user();

         $query = TelephoneMobile::latest();

        if ($request->filled('matricule')) {
            $query->where('matricule', $request->matricule);
        }

        $telephones = $query->paginate(3)->withQueryString();

        return view('stock.telephone_mobiles.index', compact('telephones', 'user'));
    }

    /**
     * ➕ Formulaire création
     */
    public function create()
    {
        return view('telephone_mobiles.create');
    }

    /**
     * 💾 Enregistrer
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'matricule'                  => 'nullable|string',
            'nom'                        => 'nullable|string',
            'prenom'                     => 'nullable|string',
            'service'                    => 'nullable|string',
            'destination'                => 'nullable|string',
            'modele_telephone'           => 'nullable|string',
            'reference_telephone'        => 'nullable|string',
            'montant_ancien_forfait_ttc' => 'nullable|string',
            'numero_sim'                 => 'nullable|string',
            'formule_premium'            => 'nullable|string',
            'montant_forfait_ttc'        => 'nullable|string',
            'code_puk'                   => 'nullable|string',
            'acquisition_date'           => 'nullable|string',
            'statut'                     => 'nullable|string',
            'cause_changement'           => 'nullable|string',
            'imsi'                       => 'nullable|string',
        ]);

        TelephoneMobile::create($data);

        return redirect()
            ->route('telephone-mobiles.index')
            ->with('success', 'Téléphone ajouté avec succès');
    }

    /**
     * ✏️ Édition
     */
    public function edit(TelephoneMobile $telephoneMobile)
    {
        return view('telephone_mobiles.edit', compact('telephoneMobile'));
    }

    /**
     * 🔄 Mise à jour
     */
    public function update(Request $request, TelephoneMobile $telephoneMobile)
    {
        $data = $request->validate([
            'matricule'                  => 'nullable|string',
            'nom'                        => 'nullable|string',
            'prenom'                     => 'nullable|string',
            'service'                    => 'nullable|string',
            'destination'                => 'nullable|string',
            'modele_telephone'           => 'nullable|string',
            'reference_telephone'        => 'nullable|string',
            'montant_ancien_forfait_ttc' => 'nullable|string',
            'numero_sim'                 => 'nullable|string',
            'formule_premium'            => 'nullable|string',
            'montant_forfait_ttc'        => 'nullable|string',
            'code_puk'                   => 'nullable|string',
            'acquisition_date'           => 'nullable|string',
            'statut'                     => 'nullable|string',
            'cause_changement'           => 'nullable|string',
            'imsi'                       => 'nullable|string',
        ]);

        $telephoneMobile->update($data);

        return redirect()
            ->route('telephone-mobiles.index')
            ->with('success', 'Téléphone mis à jour');
    }

    /**
     * 🗑️ Suppression
     */
    public function destroy(TelephoneMobile $telephoneMobile)
    {
        $telephoneMobile->delete();

        return redirect()
            ->route('telephone-mobiles.index')
            ->with('success', 'Téléphone supprimé');
    }

    /**
     * 📥 Import Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(
            new TelephoneMobileImport,
            $request->file('file')
        );

        return back()->with('success', 'Import terminé');
    }

    /**
     * 📤 Export Excel
     */
    public function export()
    {
        return Excel::download(
            new TelephoneMobileExport,
            'telephone_mobiles.xlsx'
        );
    }
}
