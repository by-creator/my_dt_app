@component('mail::message')

<img src="https://site-dt-staging-4682ed3f9fbf.herokuapp.com/templates/site/images/logo.png" alt="Logo" width="150" style="margin-bottom: 20px;">

# Redirection vers plateforme



Afin de vous connecter sur notre plateforme merci de bien vouloir cliquer sur le lien ci-dessous : 

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
LIEN D'ACCÈS PLATEFORME
@endcomponent

---

DAKAR-TERMINAL

@endcomponent
