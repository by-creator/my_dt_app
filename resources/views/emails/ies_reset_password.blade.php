@component('mail::message')
# Réinitialisation de votre mot de passe

Bonjour,

Votre mot de passe a été réinitialisé avec succès. Voici vos nouvelles informations de connexion :

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