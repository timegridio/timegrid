@extends('app')

@section('content')
{!! Form::open(['route' => ['user.booking.store', $business], 'class' => 'form']) !!}
{!! Form::hidden('businessId', $business->id, ['required'] ) !!}
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            @include('user.appointments.dateslot._timetable', ['dates' => $availability, 'business' => $business])
        </div>

        <div id="extra" class="hidden">

            {!! Form::hidden('_date', null, [
                'required',
                'class'=>'form-control',
                'id'=>'date',
                'min'=> date('Y-m-d'),
                'placeholder'=> trans('user.appointments.form.date.label')
                ]) !!}

            {!! Form::hidden('service_id', null, [
                'required',
                'id'=>'service',
                'class'=>'form-control',
                'placeholder'=> trans('user.appointments.form.service.label')
                ]) !!}

            <div class="row">
                <div class="form-group col-sm-12">
                    {!! Form::label( trans('user.appointments.form.comments.label') ) !!}
                    {!! Form::text('comments', null, [
                        'class'=>'form-control',
                        'placeholder'=> trans('user.appointments.form.comments.label')
                        ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-12">
                    {!! Button::primary(trans('user.appointments.form.btn.submit'))->block()->submit() !!}
                </div>
            </div>
        
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection