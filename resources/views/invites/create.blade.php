@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form action="{{action('InviteController@store')}}" method="post">
                @csrf

                <div class="form-group">
                    <label for="name">Client</label>
                    <input name="name" type="text" class="form-control" id="name" aria-describedby="titleHelp" placeholder="Nume si prenume" value="{{old('name')}}">
                    <small id="titleHelp" class="form-text text-muted"></small>

                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="titleHelp" placeholder="Email" value="{{old('email')}}">
                    <small id="titleHelp" class="form-text text-muted">Clientul va primi o invitiatie la aceasta casuta de mail</small>

                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="invited">Trimit invitatie?</label>
                    {{Form::checkbox('invited', old('invited'), true)}}

                    @error('invited')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <button type="submit" class="btn btn-primary">Trimite invitatie</button>

            </form>
        </div>
    </div>
@endsection
