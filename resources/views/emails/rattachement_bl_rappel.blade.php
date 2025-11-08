@component('mail::message')
# Rappel : Dossiers toujours en attente

Bonjour,


Il y a actuellement **{{ $count }} dossier(s)** avec le statut **EN ATTENTE**.

@component('mail::table')
| Nom | Prénom | Email | BL | Créé le |
|-----|---------|-------|----|---------|
@foreach ($dossiers as $d)
| {{ $d->nom }} | {{ $d->prenom }} | {{ $d->email }} | {{ $d->bl }} | {{ $d->created_at->format('d/m/Y H:i') }} |
@endforeach
@endcomponent

Merci de vous connecter sur notre plateforme de facturation en cliquant sur le lien ci-dessous :

@component('mail::button', ['url' => 'https://site-dt-production-98050a853413.herokuapp.com/demat'])
LIEN D'ACCÈS PLATEFORME
@endcomponent



---

DAKAR-TERMINAL
@endcomponent