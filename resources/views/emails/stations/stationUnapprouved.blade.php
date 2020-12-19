@component('mail::message')
# Station Rejetée

Nous vous informons que votre station  {{ $data['station'] }} a été rejetée malheureusement. <br>

@component('mail::panel')
{{ $data['motif'] }}
@endcomponent


Cordialement,<br>
{{ config('app.name') }}
@endcomponent

