@extends('app')

@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
@endsection

@section('content')
{!! Form::open(['route' => 'user.booking.store', 'class' => 'form']) !!}
{!! Form::hidden('businessId', $business->id, ['required', 'id' => 'business'] ) !!}
{!! Form::hidden('_date', null, array('required', 'class'=>'form-control', 'id'=>'date', 'min'=> date('Y-m-d') )) !!}

<div class="container">
    <div class="row">
        @include('user.appointments.timeslot._timetable', ['dates' => $availability])
    </div>

    <div class="row">

        <div class="form-group col-sm-6">
            {!! Form::label( trans('user.appointments.form.time.label') ) !!}
            <br/>
            <select id="times" name="_time"></select>
        </div>

        <div class="form-group col-sm-6">
            {!! Form::label( trans('user.appointments.form.duration.label') ) !!}
            {!! Form::text('duration', 0,
                array('readonly',
                      'id'=>'duration',
                      'class'=>'form-control',
                      'placeholder'=> trans('user.appointments.form.duration.label') )) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-12">
            {!! Form::hidden('service_id', 0,
                array('required',
                      'id'=>'service',
                      'class'=>'form-control',
                      'placeholder'=> trans('user.appointments.form.service.label') )) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-12">
            {!! Form::label( trans('user.appointments.form.comments.label') ) !!}
            {!! Form::text('comments', 'test',
                array('required',
                      'class'=>'form-control',
                      'placeholder'=> trans('user.appointments.form.comments.label') )) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
            {!! Button::primary(trans('manager.contacts.btn.store'))->block()->submit() !!}
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
