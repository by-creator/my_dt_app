<?php

namespace App\Http\Controllers;

use App\Mail\CreateUnifyTiersMail;
use App\Models\TiersIpaki;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UnifyController extends Controller
{
    public function index()
    {
        return view('unify.index');
    }

    public function create()
    {
        return view('unify.index');
    }

    public function tutorial()
    {
        return view('unify.tutoriel');
    }

    public function add(Request $request)
    {
        $action = $request->input('submit');

        if ($action === 'sendTiers') {

            return $this->sendTiers($request);
        }

        if ($action === 'fiche') {

            return $this->createFiche($request);
        }

        if ($action === 'attestation') {
            return $this->createAttestation($request);
        }

        return redirect()->back()->withErrors('Action inconnue.');
    }

    public function sendTiers(Request $request)
    {

        $data = [
            'code' => $ipaki_id = str_replace(' ', '', $request->ipaki_id),
            'label' => $request->social_reason,
            'active' => "TRUE",
            'billable' => "TRUE",
            'accounting_id' => $request->neptune_id,
        ];


        TiersIpaki::create($data);


        $raison_sociale = $request->social_reason;
        $ipaki_id = $ipaki_id = str_replace(' ', '', $request->ipaki_id);

        $destinataires = [
            /*
            'sophie-yande.diouf@dakar-terminal.com',
            'dieynaba.sy@dakar-terminal.com',*/
            'noreplysitedt@gmail.com'
        ];

        Mail::to($destinataires)->send(new CreateUnifyTiersMail($raison_sociale,$ipaki_id));

        return redirect()->back()->with('create', 'Un mail de vérification contenant le numéro de compte a bien été envoyé aux administrateurs');

    }

    public function createFiche(Request $request)
    {
        $dateString = $request->date;
        $date = Carbon::parse($dateString);

        $expiration_dateString = $request->expiration_date;
        $expiration_date = Carbon::parse($expiration_dateString);


        $creation_dateString = $request->creation_date;
        $creation_date = Carbon::parse($creation_dateString);

        $ipaki_id = $request->ipaki_id;
        $neptune_id = $request->neptune_id;
        $type = $request->type;
        $social_reason = $request->social_reason;
        $address = $request->address;
        $telephone = $request->telephone;
        $email = $request->email;
        $city = $request->city;
        $country = $request->country;
        $cni = $request->cni;
        $sigle = $request->sigle;
        $juridic_form = $request->juridic_form;
        $juridic_status = $request->juridic_status;
        $group = $request->group;
        $titre_exo = $request->titre_exo;
        $ninea = $request->ninea;
        $rc = $request->rc;
        $dg = $request->dg;
        $dg_phone = $request->dg_phone;
        $daf = $request->daf;
        $daf_phone = $request->daf_phone;

        $data = [
            'date' => $date,
            'type' => $type,
            'ipaki_id' => $ipaki_id,
            'neptune_id' => $neptune_id,
            'social_reason' => $social_reason,
            'address' => $address,
            'telephone' => $telephone,
            'email' => $email,
            'city' => $city,
            'country' => $country,
            'cni' => $cni,
            'expiration_date' => $expiration_date,
            'creation_date' => $creation_date,
            'sigle' => $sigle,
            'juridic_form' => $juridic_form,
            'juridic_status' => $juridic_status,
            'group' => $group,
            'titre_exo' => $titre_exo,
            'ninea' => $ninea,
            'rc' => $rc,
            'dg' => $dg,
            'dg_phone' => $dg_phone,
            'daf' => $daf,
            'daf_phone' => $daf_phone,

        ];
        return view('unify.fiche', compact('data'));
    }

    public function createAttestation(Request $request)
    {
        $dateString = $request->date;
        $date = Carbon::parse($dateString);

        $ipaki_id = $request->ipaki_id;
        $neptune_id = $request->neptune_id;
        $type = $request->type;
        $social_reason = $request->social_reason;
        $address = $request->address;
        $ninea = $request->ninea;
        $rc = $request->rc;

        $data = [
            'date' => $date,
            'type' => $type,
            'ipaki_id' => $ipaki_id,
            'neptune_id' => $neptune_id,
            'social_reason' => $social_reason,
            'address' => $address,
            'ninea' => $ninea,
            'rc' => $rc,

        ];
        return view('unify.attestation', compact('data'));
    }
}
