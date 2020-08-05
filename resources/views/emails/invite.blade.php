@component('mail::message')
# Salut {{$invite->name}},

Urmareste click-ul de mai jos pentru a-ti valida documentele.


@component('mail::button', ['url' => url('/app/'.$invite->tracking_id)])
VALIDARE DOCUMENTE
@endcomponent

<br>
Echipa <a href="https://atftax.co.uk/"> ATF Accountancy</a>
@endcomponent
