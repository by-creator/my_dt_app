<?php

namespace App\Http\Controllers;

use App\Mail\RattachementBlInvalideMail;
use App\Mail\RattachementBlValideMail;
use App\Models\RattachementBl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RattachementController extends Controller
{
    public function index()
    {
        $rattachement_validations = RattachementBl::orderBy('id', 'desc')->get();
        $rattachements = RattachementBl::orderBy('id', 'desc')->get();
        $users = User::all();
        return view('rattachement_bl.index', compact('rattachements', 'rattachement_validations', 'users'));
    }

    public function delete($id)
    {
        $rattachement = RattachementBl::findOrFail($id);

        if ($rattachement->statut == "EN ATTENTE") {
            $rattachement->user_id = Auth::user()->id;
            $rattachement->statut = "VALIDÉ";

            $destinataires = [
            /*
            'sn004-proforma@dakar-terminal.com',
            'sn004-facturation@dakar-terminal.com',*/
            $rattachement->email,
            'noreplysitedt@gmail.com'
        ];

            Mail::to($destinataires)->send(new RattachementBlValideMail($rattachement->bl, $rattachement->nom, $rattachement->prenom));

            $rattachement->save();

            return redirect()->back()->with('valide', 'Dossier validé avec succès.');
        }
        else{
            return redirect()->back()->with('error', 'Dossier déjà traité.');
        }
    }

    public function update($id, Request $request)
    {
        $rattachement = RattachementBl::findOrFail($id);

        if ($rattachement->statut == "EN ATTENTE") {
            $rattachement->user_id = Auth::user()->id;
            $rattachement->statut = "REJETÉ";

            $destinataires = [
            /*
            'sn004-proforma@dakar-terminal.com',
            'sn004-facturation@dakar-terminal.com',*/
            $rattachement->email,
            'noreplysitedt@gmail.com'
        ];

            $motif = $request->motif;

            Mail::to($destinataires)->send(new RattachementBlInvalideMail($rattachement->bl, $rattachement->nom, $rattachement->prenom, $motif));

            $rattachement->save();

            return redirect()->back()->with('valide', 'Dossier rejeté avec succès.');
        }
        else{
            return redirect()->back()->with('error', 'Dossier déjà traité.');
        }
    }
}
