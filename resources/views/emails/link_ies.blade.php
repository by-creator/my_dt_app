@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>

# Redirection vers plateforme



Désormais pour toutes vos demandes de validation, obtention de factures et paiement merci de cliquer sur le lien ci-dessous : 

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
LIEN D'ACCÈS PLATEFORME
@endcomponent

---

DAKAR-TERMINAL

@endcomponent
