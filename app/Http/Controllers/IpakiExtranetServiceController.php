<?php

namespace App\Http\Controllers;

use App\Mail\CreateIpakiExtranetServiceMail;
use App\Mail\LinkIesMail;
use App\Mail\ResetPasswordIpakiExtranetServiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IpakiExtranetServiceController extends Controller
{
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

    public function sendResetPassword(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        Mail::to($email)->send(new ResetPasswordIpakiExtranetServiceMail($email, $password));

        return redirect()->route('ies.reset-password')->with('reset', 'Un mail de réinitialisation contenant les informations de connexion a bien été envoyé à cette adresse : ' . $email);
    }

    public function sendCreate(Request $request)
    {
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

    public function sendValidation() 
    {
        
    }

    public function demat()
    {
        return view('ies.demat');
    }
}
