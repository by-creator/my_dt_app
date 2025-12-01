@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>


# Demande de BAD

Bonjour,

Je me présente {{ $data['prenom'] }} {{ $data['nom'] }} et je souhaite avoir le BAD du dossier ci-dessous : 

**Bil of Lading (BL)** : {{ $data['bl'] }}  

**Compte** : {{ $data['compte'] }}  



---

DAKAR-TERMINAL

@endcomponent
