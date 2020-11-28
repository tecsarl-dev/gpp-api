@component('mail::message')
# Bienvenue sur {{ config('app.name') }}

Votre Code De Vérification: <span style="font-size: 1.25rem; font-weight:600;">{{$data['code']}}</span><br>

Si vous n'avez pas ouvert de compte, Aucune action n'est requise 

Cordialement,<br>
{{ config('app.name') }}
@endcomponent