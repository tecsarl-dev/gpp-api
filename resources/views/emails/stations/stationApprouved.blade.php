@component('mail::message')
# Station Approuvée

Nous vous informons que votre station {{ $data['station'] }} a été approuvée avec succès. <br>

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
