<?php

namespace App\Http\Controllers;

use App\Mail\CreateIpakiExtranetServiceMail;
use App\Mail\InvalideAccountIesMail;
use App\Mail\LinkIesMail;
use App\Mail\ResetPasswordIpakiExtranetServiceMail;
use App\Mail\ValidationIesMail;
use App\Mail\ValideAccountIesMail;
use App\Models\RattachementBl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IpakiExtranetServiceController extends Controller
{
    public function validation()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'FACTURATION');
        })->get();


        return view('ies.validation', compact('users'));
    }
    public function create()
    {
        return view('ies.create');
    }

    public function resetPassword()
    {
        return view('ies.reset-password');
    }

    public function link()
    {
        return view('ies.link');
    }
    public function sendValidationAccount(Request $request)
    {
        // Validation des champs
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email',
            'statut' => 'required|in:VALIDE,INVALIDE',
        ]);

        $user = User::findOrFail($request->user_id);
        $email = $request->email;

        // Selon le statut, on envoie un mail différent
        if ($request->statut === 'VALIDE') {
            Mail::to($user->email)->send(new ValideAccountIesMail($user, $email));
            $message = "Mail de validation envoyé à {$user->email}";
        } else {
            Mail::to($user->email)->send(new InvalideAccountIesMail($user, $email));
            $message = "Mail d’invalidation envoyé à {$user->email}";
        }

        Mail::to($email)->send(new LinkIesMail($email));

        return redirect()->route('ies.validation')->with('validation', $message);
    }
    
    public function sendResetPassword(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        Mail::to($email)->send(new ResetPasswordIpakiExtranetServiceMail($email, $password));

        return redirect()->route('ies.reset-password')->with('reset', 'Un mail de réinitialisation contenant les informations de connexion a bien été envoyé à cette adresse : ' . $email);
    }

    public function sendCreate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        Mail::to($email)->send(new CreateIpakiExtranetServiceMail($email, $password));

        return redirect()->route('ies.create')->with('create', 'Un mail contenant les informations de connexion a bien été envoyé à cette adresse : ' . $email);
    }



    public function sendLink(Request $request)
    {
        $email = $request->input('email');
        Mail::to($email)->send(new LinkIesMail($email));
        return redirect()->route('ies.link')->with('link', 'Un mail contenant un lien  vers la plateforme a bien été envoyé à cette adresse : ' . $email);
    }

    public function sendValidation(Request $request)
    {
        $data = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'bl' => 'required|string',
            'compte' => 'required|string',
            'documents.*' => 'file|max:10240',
        ]);

        $documents = [];     // Chemins des fichiers
        $fileNames = [];     // Noms originaux

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $documents[] = $file; // 🔹 on garde directement l'objet UploadedFile
                $fileNames[] = $file->getClientOriginalName();
            }
        }

        $destinataires = [
            
            'sn004-proforma@dakar-terminal.com',
            'sn004-facturation@dakar-terminal.com',
            //'noreplysitedt@gmail.com'
        ];


        $nomComplet = $data['prenom'] . ' ' . $data['nom'];

        Mail::to($destinataires)->send(
            new ValidationIesMail(
                bl: $data['bl'],
                compte: $data['compte'],
                documents: $documents,   // fichiers bruts
                fileNames: $fileNames,   // noms d’origine
                expediteurEmail: $data['email'],
                expediteurNom: $nomComplet
            )
        );

        
        $data_create = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'bl' => 'required|string',
            'compte' => 'required|string',
        ]);

        RattachementBl::create($data_create);

        return redirect()
            ->route('demat.index')
            ->with('sendValidation', 'Un mail de demande de validation a bien été envoyé au service facturation qui vous fera un retour par mail une fois la validation effecuée.');
    }

    public function demat()
    {
        return view('ies.demat');
    }
}
