@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading">{{ trans('user.contacts.create.title') }}</div>

            <div class="panel-body">
                @include('_errors')

                {!! Form::model($contact, ['method' => 'put', 'route' => ['user.business.contact.update', $business, $contact->id ]]) !!}
                    @include('user.contacts._form', ['submitLabel' => trans('user.contacts.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection
