@extends('emails.'.App::getLocale() . '.layout')

@section('content')
Usuarios Registrados: {{ $registeredUsersCount }}
@endsection