@extends('layouts.app')

@section('content')
<div class="container">
    {!! Alert::info(trans('manager.humanresources.create.instructions')) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ trans('manager.humanresources.create.title') }}
        </div>

        <div class="panel-body">
            @include('_errors')

            {!! Form::model($humanresource, ['route' => ['manager.business.humanresource.store', $business]]) !!}
                @include('manager.businesses.humanresources._form', ['submitLabel' => trans('manager.humanresource.btn.store')])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection