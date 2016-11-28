@extends('layouts.app')

@section('title', trans('manager.humanresource.create.title'))
@section('subtitle', trans('manager.humanresource.create.subtitle'))

@section('content')
<div class="container-fluid">
    {!! Alert::info(trans('manager.humanresource.create.instructions')) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ trans('manager.humanresource.create.title') }}
        </div>

        <div class="panel-body">
            {!! Form::model($humanresource, ['route' => ['manager.business.humanresource.store', $business], 'class' => 'horizontal-form']) !!}
                @include('manager.businesses.humanresources._form', ['submitLabel' => trans('manager.humanresource.btn.store')])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection