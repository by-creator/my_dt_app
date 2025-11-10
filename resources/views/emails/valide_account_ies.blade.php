@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>


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