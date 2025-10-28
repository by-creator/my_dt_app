@component('mail::message')
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

Cet e-mail a été envoyé automatiquement via l’application de dématérialisation.

@endcomponent
