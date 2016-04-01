@extends('layouts.app')

@section('title', trans('manager.contacts.create.title'))

@section('content')
<div class="container-fluid">

        <div class="panel panel-default">

            <div class="panel-heading">{{ trans('manager.contacts.create.title') }}</div>

            <div class="panel-body">

                {!! Form::model($contact, ['method' => 'put', 'route' => ['manager.addressbook.update', $business, $contact ]]) !!}
                    @include('manager.contacts._form', ['submitLabel' => trans('manager.contacts.btn.update')])
                {!! Form::close() !!}

            </div>

        </div>

</div>
@endsection
