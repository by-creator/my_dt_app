@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png"
        alt="Logo" width="150" style="margin-bottom: 20px;">
</p>


# Facture définitive disponible

Bonjour {{ $data['prenom'] }} {{ $data['nom'] }},

Votre facture est disponible sur notre plateforme accessible en cliquant sur le lien ci-dessous :


@component('mail::button', ['url' => 'http://localhost:8000/demat'])
LIEN D'ACCÈS PLATEFORME
@endcomponent


---

DAKAR-TERMINAL

@endcomponent