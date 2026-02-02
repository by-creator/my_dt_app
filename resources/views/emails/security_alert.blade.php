@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>

# Alerte de sécurité

Bonjour,

Nous avons détecté une activité suspecte sur votre compte. Pour des raisons de sécurité, veuillez cliquer sur le lien ci-dessous pour vérifier votre compte :

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
LIEN D'ACCÈS PLATEFORME
@endcomponent

---

DAKAR-TERMINAL

@endcomponent
