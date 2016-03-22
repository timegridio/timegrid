@extends('layouts.app')

@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

@section('content')
{!! Form::open(['route' => ['user.booking.store', 'business'], 'class' => 'form']) !!}
{!! Form::hidden('businessId', $business->id, ['required', 'id' => 'business']) !!}
{!! Form::hidden('_date', null, ['required', 'id'=>'date', 'min'=> date('Y-m-d')]) !!}
{!! Form::hidden('service_id', null, ['required', 'id'=>'service']) !!}

<div class="container-fluid">
    <div class="col-md-8 col-md-offset-2">

        <div class="row">
            @include('user.appointments.timeslot._timetable', ['dates' => $availability])
        </div>

        <div id="extra" class="hidden">
            <div class="row">
                <div class="form-group col-sm-5">
                    {!! Form::label(trans('user.appointments.form.time.label')) !!}
                    <br/>
                    <select id="times" name="_time" class="form-control"></select>
                </div>

                <div class="form-group col-sm-7">
                    {!! Form::label(trans('user.appointments.form.duration.label')) !!}
                    {!! Form::text('duration', null, [
                        'readonly',
                        'id'=>'duration',
                        'class'=>'form-control',
                        'placeholder'=> trans('user.appointments.form.duration.label')
                        ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-12">
                    {!! Form::label(trans('user.appointments.form.comments.label')) !!}
                    {!! Form::text('comments', null, [
                        'class'=>'form-control',
                        'placeholder'=> trans('user.appointments.form.comments.label')
                        ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-12">
                    {!! Button::primary(trans('user.appointments.btn.book'))->large()->block()->submit() !!}
                </div>
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}
@endsection

@section('footer_scripts')
@parent
<script src="{{ asset('js/forms.js') }}"></script>
@endsection