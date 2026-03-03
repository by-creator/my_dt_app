<?php

namespace App\Http\Controllers;

use App\Mail\CreateIpakiExtranetServiceMail;
use App\Mail\InvalideAccountIesMail;
use App\Mail\LinkIesMail;
use App\Mail\ResetPasswordIpakiExtranetServiceMail;
use App\Mail\ValidationIesMail;
use App\Mail\ValideAccountIesMail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IpakiExtranetServiceController extends Controller
{
    public function dematerialisation()
    {   
        return view('ies.dematerialisation');
    }
    
    public function validation()
    {
        $user = Auth::user();

        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'FACTURATION');
        })->get();


        return view('ies.validation', compact('users', 'user'));
    }
    public function create()
    {
        $user = Auth::user();
        return view('ies.create', compact('user'));
    }

    public function resetPassword()
    {
         $user = Auth::user();
        return view('ies.reset-password', compact('user'));
    }

    public function link()
    {
         $user = Auth::user();
        return view('ies.link', compact('user'));
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

    public function demat()
    {
        return view('ies.demat');
    }
}
