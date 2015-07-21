@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('manager.businesses.create.title') }}</div>

            <div class="panel-body">
                @include('_errors')

                {!! Form::model(new App\Business, ['route' => ['manager.business.store'], 'id' => 'registration', 'data-toggle' => 'validator']) !!}
                @include('manager.businesses._form', ['submitLabel' => trans('manager.businesses.btn.store')])
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection
