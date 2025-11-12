@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>


# Demande de validation du dossier

Bonjour,

Je me présente {{ $prenom }} {{ $nom }} et je souhaite valider le dossier ci-dessous : 

**Bil of Lading (BL)** : {{ $bl }}  
**Compte Client** : {{ $compte }}

---

DAKAR-TERMINAL

@endcomponent
