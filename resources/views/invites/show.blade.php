@extends('layouts.app')

@section('content')
    <div class="container">
    @forelse ($invites as $invite)
        <div class="row">
            <ul>
                <li>Nume: {{ $invite->name }}</li>
                <li>Email: {{ $invite->email }}</li>
                <li>A fost invitat?: {{ $invite->invited?'Da':'Nu' }}</li>
                <li>A accesat link-ul?: {{ $invite->link_accessed?'Da':'Nu' }}</li>
                <li>Tracking link: <a href="{{ url('/app/'.$invite->tracking_id) }}">{{ $invite->tracking_id }}</a></li>
                <li>
                    Reusite:
                    <ul>
                        @foreach($invite->applications()->get() as $a)
                            <li>{{$a->created_at}} - <a href="{{route('invites.applications.show',[$invite->id,$a->id])}}">result</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            {{ Form::open([ 'method'  => 'delete', 'route' => [ 'invites.destroy', $invite->id ] ]) }}
                {{ Form::submit('Sterge', ['class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        </div>
    @empty
        <p>No invites to show</p>
    @endforelse
        <div class="row">
            <a class="btn btn-success" href="{{route('invites.create')}}">creaza invitatie</a>
        </div>
    </div>
@endsection
