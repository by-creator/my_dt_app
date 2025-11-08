@component('mail::message')
# Dossier rejeté

Bonjour {{ $prenom }} {{ $nom }},

Votre dossier dont voici le numéro de BL **{{ $bl }}** a été rejeté pour le motif ci-dessous : 

**Motif :** {{ $motif }}
<br>
<br>

Merci de refaire votre demande en complétant le dossier si nécessaire.

Pour accéder à notre plateforme en cliquant sur le lien ci-dessous :

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
LIEN D'ACCÈS PLATEFORME
@endcomponent



---

DAKAR-TERMINAL
@endcomponent