@extends('emails.'.App::getLocale() . '.layout')

@section('content')
Users Registered: {{ $registeredUsersCount }}
@endsection