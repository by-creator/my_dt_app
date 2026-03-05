@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>

# Demande de remise validée ✅

Bonjour {{ $prenom }} {{ $nom }},

Votre demande de remise pour le BL **{{ $bl }}** a été validée.

**Pourcentage accordé : {{ $pourcentage }} %**

**Date de validité : {{ $date->format('d/m/Y') }}**

Merci pour votre confiance.

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
ACCÉDER À LA PLATEFORME
@endcomponent

---
DAKAR TERMINAL
@endcomponent