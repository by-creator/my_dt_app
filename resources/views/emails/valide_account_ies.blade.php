@component('mail::message')
# Validation de compte effectuée

Bonjour {{ $user->name }},

Le compte du client ci-dessous a bien été validé, un mail contenant le lien vers notre plateforme lui a été transmis.

**Email :** {{ $email }}
<br>
<br>

Merci de bien vouloir assister ce dernier afin qu'il sache comment procéder pour valider, facturer, payer et avoir
son BAD directement sur la plateforme.

---

DAKAR-TERMINAL
@endcomponent