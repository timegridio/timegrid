@extends('app')

@section('content')

    @foreach ($notifications as $notification)
        <div class="well">{{$notification->from_id}} {{$notification->text}}</div>
    @endforeach

@endsection