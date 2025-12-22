@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>


# Bon à délivrer (BAD) Indisponible

Bonjour {{ $prenom }} {{ $nom }},

Votre dossier dont voici le numéro de BL **{{ $bl }}** ne peut avoir bon à délivrer (BAD) pour le motif ci-dessous : 

**Motif :** {{ $motif }} {{ $autre_motif }}
<br>
<br>

Merci de vous rapprocher de la facturation si nécessaire.

Pour accéder à notre plateforme cliquez sur le lien ci-dessous :

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
LIEN D'ACCÈS PLATEFORME
@endcomponent



---

DAKAR-TERMINAL
@endcomponent