@extends('beautymail::templates.widgets')

@section('content')

    @include('beautymail::templates.widgets.articleStart')

        <h4 class="secondary"><strong>Users:</strong></h4>
        <p>There are {{ $registeredUsersCount }} registered users so far</p>

    @include('beautymail::templates.widgets.articleEnd')

@stop