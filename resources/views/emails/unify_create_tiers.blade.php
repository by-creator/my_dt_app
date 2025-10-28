@component('mail::message')
# Création de compte sur Unify

Bonjour,

Merci de bien vouloir vérifier le terme de paiement de ce compte tiers afin de pouvoir le mettre à jour si nécessaire :

**Raison sociale :** **{{ $raison_sociale }}**
<br>
<br>
**Numéro de compte :** **{{ $ipaki_id }}**
<br>
<br>

Cordialement,<br>
{{ config('app.name') }}
@endcomponent