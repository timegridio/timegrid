@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('manager.contacts.create.title') }}</div>

            <div class="panel-body">
                {!! Form::model($service, ['method' => 'put', 'route' => ['manager.business.service.update', $service->business, $service->id]]) !!}
                    @include('manager.businesses.services._form', ['submitLabel' => trans('manager.service.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection
