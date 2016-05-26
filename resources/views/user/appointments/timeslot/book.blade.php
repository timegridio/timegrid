@extends('layouts.user')

@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

@section('content')
{!! Form::open(['route' => ['user.booking.store', 'business'], 'class' => 'form']) !!}
{!! Form::hidden('businessId', $business->id, ['required', 'id' => 'business']) !!}
{!! Form::hidden('_date', null, ['required', 'id'=>'date', 'min'=> date('Y-m-d')]) !!}
{!! Form::hidden('_timezone', null, ['id'=>'timezone', 'readonly']) !!}
{!! Form::hidden('service_id', null, ['required', 'id'=>'service']) !!}
{!! Form::hidden('contact_id', $contact->id, ['required', 'id'=>'contact']) !!}

<div class="container-fluid">

    <div class="col-md-6 col-md-offset-3">

        <div id="panel" class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">{{ trans('user.appointments.alert.book_in_biz_on_behalf_of', ['biz' => $business->name, 'contact' => $contact->fullname()]) }}</div>

        @include('user.appointments.timeslot._timetable', ['dates' => $availability])

        <div class="container-fluid">
        <div id="extra" class="hide">

            <div class="row">
                <div class="form-group col-sm-12">
                @if(isset($canEditDuration))
                    {!! Form::label(trans('user.appointments.form.duration.label_edit')) !!}
                    {!! Form::text('duration', null, [
                        'id'=>'duration',
                        'class'=>'form-control',
                        'placeholder'=> trans('user.appointments.form.duration.label')
                        ]) !!}
                @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="comments">{{ trans('user.appointments.form.time.label') }}</label>
                    <br/>
                    <select id="times" name="_time" class="form-control"></select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="comments">{{ trans('user.appointments.form.comments.label') }}</label>
                    {!! Form::text('comments', null, [
                        'id'=>'comments',
                        'class'=>'form-control',
                        'placeholder'=> trans('user.appointments.form.comments.label')
                        ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-12">
                    {!! Button::success(trans('user.appointments.btn.confirm_booking'))->large()->block()->submit() !!}
                </div>
            </div>

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