@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>

# Demande de remise en attente de validation

Bonjour,

Vous avez une demande de remise en attente de validation pour le dossier ci-dessous :  

 **Numéro de BL** : **{{ $bl }}**.


Merci de bien vouloir vous connecter à la plateforme afin de traiter cette demande.

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
ACCÉDER À LA PLATEFORME
@endcomponent

---
DAKAR TERMINAL
@endcomponent