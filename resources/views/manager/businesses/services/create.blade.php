@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {!! Alert::info(trans('manager.services.create.instructions')) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ trans('manager.services.create.title') }}
        </div>

        <div class="panel-body">
            @include('_errors')

            {!! Form::model($service, ['route' => ['manager.business.service.store', $business]]) !!}
                @include('manager.businesses.services._form', ['submitLabel' => trans('manager.services.btn.store')])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection