@extends('layouts.user')

@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

@section('content')
<div class="container">
{!! Form::open(['route' => ['user.booking.store', 'business'], 'class' => 'form', 'id' => 'form', 'data-toggle' => 'validator', 'role' => 'form']) !!}
{!! Form::hidden('businessId', $business->id, ['required', 'id' => 'business']) !!}
{!! Form::hidden('_date', null, ['required', 'id'=>'date', 'min'=> date('Y-m-d')]) !!}
{!! Form::hidden('_timezone', null, ['id'=>'timezone', 'readonly']) !!}
{!! Form::hidden('service_id', null, ['required', 'id'=>'service']) !!}
@if(isset($contact))
{!! Form::hidden('contact_id', $contact->id, ['required', 'id'=>'contact']) !!}
@endif

<h1 class="text-center">{{ $business->name }}</h1>
<div id="steps">
    @include('user.appointments.timeslot._service-picker', ['services' => $business->services])

    @include('user.appointments.timeslot._date-picker')

    @include('user.appointments.timeslot._time-picker')

    @include('user.appointments.timeslot._recap')
</div>

{!! Form::close() !!}
</div>
@endsection

@push('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>
<script>
$(document).ready(function(){

    $("#steps").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        /* Labels */
        labels: {
            cancel: "{{ trans('booking.steps.label.cancel') }}",
            current: "{{ trans('booking.steps.label.current') }}",
            pagination: "{{ trans('booking.steps.label.pagination') }}",
            finish: "{{ trans('booking.steps.label.finish') }}",
            next: "{{ trans('booking.steps.label.next') }}",
            previous: "{{ trans('booking.steps.label.previous') }}",
            loading: "{{ trans('booking.steps.label.loading') }} ..."
        },
        /* Behaviour */
        autoFocus: true,
        enableAllSteps: false,
        enableKeyNavigation: true,
        enablePagination: false,
        suppressPaginationOnFocus: true,
        enableContentCache: true,
        enableCancelButton: false,
        enableFinishButton: false,
        showFinishButtonAlways: false,
        forceMoveForward: false,
        startIndex: 0,
    });

    var steps = $("#steps");

    $('#service').change(function(){
        console.log('Selected service ' + $(this).val() );
        steps.steps("next");
    });

    $('#date').change(function(){
        console.log('Selected date ' + $(this).val() );
        steps.steps("next");
    });

    $('#times').change(function(){
        console.log('Selected time ' + $(this).val() );
        steps.steps("next");
    });

});
</script>
@endpush
