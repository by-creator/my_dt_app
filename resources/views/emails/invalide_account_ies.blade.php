@component('mail::message')
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