@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>


# Demande de validation du dossier

**Bil of Lading (BL)** : {{ $bl }}  
**Compte Client** : {{ $compte }}

@if(!empty($fileNames))
### 📎 Pièces jointes
@foreach($fileNames as $name)
- {{ $name }}
@endforeach
@else
Aucune pièce jointe n’a été transmise.
@endif

---

DAKAR-TERMINAL

@endcomponent
