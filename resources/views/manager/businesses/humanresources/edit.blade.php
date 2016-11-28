@extends('layouts.app')

@section('title', trans('manager.humanresource.edit.title'))
@section('subtitle', trans('manager.humanresource.edit.subtitle'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('manager.humanresource.create.title') }}</div>

            <div class="panel-body">
                {!! Form::model($humanresource, ['method' => 'put', 'route' => ['manager.business.humanresource.update', $humanresource->business, $humanresource->id], 'class' => 'horizontal-form']) !!}
                    @include('manager.businesses.humanresources._form', ['submitLabel' => trans('manager.humanresource.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection
