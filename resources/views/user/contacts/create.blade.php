@extends('layouts.app')

@section('content')
<div class="container">

        {!! Alert::info(trans('user.contacts.create.help')) !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('user.contacts.create.title') }}
            </div>

            <div class="panel-body">
                @include('_errors')

                {!! Form::model($contact, ['route' => ['user.business.contact.store', $business]]) !!}
                @include('user.contacts._form', ['submitLabel' => trans('user.contacts.btn.store'), 'contact' => $contact])
                {!! Form::close() !!}
            </div>
        </div>

</div>
@endsection