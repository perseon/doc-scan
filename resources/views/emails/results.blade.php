@component('mail::message')

    Urmareste click-ul de mai jos pentru a vedea rezultatul validarii.


    @component('mail::button', ['url' => url('/invites/'.$invite['invid'].'/applications/'.$invite['appid'])])
        VEZI REZULTAT
    @endcomponent

@endcomponent

