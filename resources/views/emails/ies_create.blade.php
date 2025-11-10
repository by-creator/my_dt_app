@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>

# Création de compte

Bonjour,

Votre compte a été créé avec succès. Voici vos informations de connexion :

**Email :** {{ $email }}
<br>
<br>
**Mot de passe : {{ $password }}**

Merci de vous connecter en cliquant sur le lien ci-dessous :

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
LIEN D'ACCÈS PLATEFORME
@endcomponent



---

DAKAR-TERMINAL
@endcomponent