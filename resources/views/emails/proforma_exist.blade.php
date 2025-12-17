@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>


# Facture Proforma Indisponible

Bonjour {{ $prenom }} {{ $nom }},

Votre dossier dont voici le numéro de BL **{{ $bl }}** ne peut avoir de facture proforma pour le motif ci-dessous : 

**Motif :** {{ $motif }}
<br>
<br>

Merci de faire une demande de facture définitive si nécessaire.

Pour accéder à notre plateforme cliquez sur le lien ci-dessous :

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
LIEN D'ACCÈS PLATEFORME
@endcomponent



---

DAKAR-TERMINAL
@endcomponent