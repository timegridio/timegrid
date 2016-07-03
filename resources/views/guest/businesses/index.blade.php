@extends('layouts.public')

@section('content')
<div class="container-fluid">
    <div class="col-md-8 col-md-offset-2">
        <ul class="list-group">
            @foreach ($businesses as $business)
            <li class="list-group-item">
            {!! Button::normal($business->name)->asLinkTo( route('user.businesses.home', $business) ) !!}
            {{ str_limit($business->description, 50) }}
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
