@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('manager.contacts.create.title') }}</div>

            <div class="panel-body">
                @include('_errors')

                {!! Form::model($service, ['method' => 'put', 'route' => ['manager.business.service.update', $service->business_id, $service->id]]) !!}
                    @include('manager.businesses.services._form', ['submitLabel' => trans('manager.service.btn.update')])
                {!! Form::close() !!}
            </div>

            <div class="panel-footer"></div>
        </div>
    </div>
</div>
@endsection
