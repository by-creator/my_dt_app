@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>


# Relance sur bon à délivrer (BAD)

Bonjour,

Ceci est un message de relance.

Je me présente {{ $data['prenom'] }} {{ $data['nom'] }} et je vous relance par rapport au bon à délivrer (BAD) concernant le numéro de Bl ci-dessous :

**Numéro de BL** : {{ $data['bl'] }}

---

DAKAR-TERMINAL

@endcomponent
