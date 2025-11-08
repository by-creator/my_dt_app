@component('mail::message')
# Dossier validé

Bonjour {{ $prenom }} {{ $nom }},

Votre dossier dont voici le numéro de BL ci-dessous a bien été validé : 

**Numéro de BL :** {{ $bl }}
<br>
<br>

Merci de vous connecter sur notre plateforme de facturation en cliquant sur le lien ci-dessous :

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
LIEN D'ACCÈS PLATEFORME
@endcomponent



---

DAKAR-TERMINAL
@endcomponent