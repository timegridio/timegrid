@extends('layouts.app')
@section('title', trans('user.preferences.title'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('_errors')
                    {!! Form::open(['route' => ['user.preferences'], 'id' => 'preferences', 'data-toggle' => 'validator']) !!}
                        @include('user.preferences._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
