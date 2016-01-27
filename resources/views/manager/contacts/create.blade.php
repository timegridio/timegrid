@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('manager.contacts.create.title') }}</div>

            <div class="panel-body">
                @include('_errors')

                {!! Form::model($contact, ['route' => ['manager.addressbook.store', $business]]) !!}
                    @include('manager.contacts._form',['submitLabel' => trans('manager.contacts.btn.store'), 'contact' => $contact])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
