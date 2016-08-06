@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('servicetype.title.edit') }}</div>

            <div class="panel-body">
                {!! Form::open(['method' => 'put', 'route' => ['manager.business.servicetype.update', $business]]) !!}
                    @include('manager.businesses.servicetype._form', ['submitLabel' => trans('servicetype.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection
