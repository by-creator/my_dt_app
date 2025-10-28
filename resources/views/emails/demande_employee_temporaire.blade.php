<!-- filepath: /home/marc/Documents/Code/Laravel/Dakar-Terminal/site-dt-laravel-app/resources/views/emails/ies_reset_password.blade.php -->
@component('mail::message')
# Validation demande employee temporaire

Bonjour,

Vous avez une demande de validation employee temporaire en attente

Merci de vous connecter afin de valider ou rejeter la demande.

@component('mail::button', ['url' => 'http://localhost:8000/'])
Se connecter
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent