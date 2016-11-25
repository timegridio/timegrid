@extends('layouts.app')

@section('title', trans('manager.vacancies.edit.title'))
@section('subtitle', trans('manager.vacancies.edit.instructions'))

@section('content')
<div class="container-fluid">
    <div class="col-md-8 col-md-offset-2">

        <div class="panel panel-default">

            <div class="panel-heading">{{ trans('manager.vacancies.edit.title') }}</div>

            <div class="panel-body">
                @if($advanced)
                    {!! Form::open(['method' => 'post', 'route' => ['manager.business.vacancy.storeBatch', $business], 'class' => 'horizontal-form']) !!}
                    @include('manager.businesses.vacancies._form_advanced', ['submitLabel' => trans('manager.businesses.vacancies.btn.update')])
                    {!! Form::close() !!}
                @else
                    {!! Form::open(['method' => 'post', 'route' => ['manager.business.vacancy.store', $business]]) !!}
                    @include('manager.businesses.vacancies._form', ['submitLabel' => trans('manager.businesses.vacancies.btn.update')])
                    {!! Form::close() !!}
                @endif
            </div>

        </div>
    </div>
</div>
@endsection