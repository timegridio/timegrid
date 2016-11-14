@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">

        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('manager.services.edit.title') }}</div>

            <div class="panel-body">
                {!! Form::model($service, ['method' => 'put', 'route' => ['manager.business.service.update', $service->business, $service->id], 'class' => 'form-horizontal']) !!}
                    @include('manager.businesses.services._form', ['submitLabel' => trans('manager.service.btn.update')])
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>
@endsection
