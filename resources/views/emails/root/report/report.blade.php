@extends('beautymail::templates.widgets')

@section('content')

    @include('beautymail::templates.widgets.articleStart')

        <h4 class="secondary"><strong>{{ trans('emails.text.user') }}:</strong></h4>
        <p>{{ trans('emails.text.there_are') }} {{ $registeredUsersCount }} {{ trans('emails.text.registered') }}</p>

    @include('beautymail::templates.widgets.articleEnd')

@stop