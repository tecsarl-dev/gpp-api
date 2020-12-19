@component('mail::message')
# Camion Rejeté

Nous vous informons que votre camion {{ $data['truck'] }} a été rejeté malheureusement. <br>

@component('mail::panel')
{{ $data['motif'] }}
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent

