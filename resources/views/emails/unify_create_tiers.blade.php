@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>


# Création de compte sur Unify

Bonjour,

Merci de bien vouloir vérifier le terme de paiement de ce compte tiers afin de pouvoir le mettre à jour si nécessaire :

**Raison sociale :** **{{ $raison_sociale }}**
<br>
<br>
**Numéro de compte :** **{{ $ipaki_id }}**
<br>
<br>

---

DAKAR-TERMINAL
@endcomponent