@component('mail::message')

<p style="text-align: center;">
    <img src="https://site-dt-production-98050a853413.herokuapp.com/templates/site/images/logo.png" 
         alt="Logo" width="150" style="margin-bottom: 20px;">
</p>


# Erreur sur validation de compte

Bonjour {{ $user->name }},

Le compte du client ci-dessous n'a pas été validé car ce dernier n'a pas confirmé son inscription 
au niveau de sa boîte mail.

**Email :** {{ $email }}
<br>
<br>

Merci de bien vouloir assister ce dernier afin qu'il puisse confirmer son inscription.

---

DAKAR-TERMINAL
@endcomponent