@component('mail::message')

# Suivi des tickets

Bonjour,

Veuillez trouver en pièce jointe **l'export des tickets du {{ $date }}**.

@if (now()->isFriday())
> ⚠️ Dernier export de la semaine
@endif

Merci,
L'équipe IT

---

DAKAR-TERMINAL
@endcomponent
