@component('mail::message')
# Compte Entreprise Rejeté

Nous vous informons que votre compte entreprise a été rejeté malheureusement. <br>

@component('mail::panel')
{{ $data['motif'] }}
@endcomponent

Connectez-vous pour soumettre à nouveau.
Cordialement,<br>
{{ config('app.name') }}
@endcomponent

