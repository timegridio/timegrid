@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('manager.vacancies.edit.title') }}</div>

            <div class="panel-body">
                @include('_errors')

                {!! Form::open(['method' => 'post', 'route' => ['manager.business.vacancy.store', $business->id]]) !!}
                @include('manager.businesses.vacancies._form', ['submitLabel' => trans('manager.businesses.vacancies.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection