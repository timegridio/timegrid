@extends('layouts.app')

@section('title', trans('manager.contacts.create.title'))

@section('content')
<div class="container-fluid">

        <div class="panel panel-default">

            <div class="panel-heading">{{ trans('manager.contacts.create.title') }}</div>

            <div class="panel-body">

                {!! Form::model($contact, ['route' => ['manager.addressbook.store', $business], 'class' => 'horizontal-form']) !!}
                    @include('manager.contacts._form', ['submitLabel' => trans('manager.contacts.btn.store'), compact('$contact')])
                {!! Form::close() !!}

            </div>

        </div>

</div>
@endsection
