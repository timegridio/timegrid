@extends('layouts.app')

@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/datetime.css') }}">
@endsection

@section('content')
<div id="calendar"></div>
@endsection

@section('footer_scripts')
@parent
<script src="{{ asset('js/datetime.js') }}"></script>
<script>
$(document).ready(function(){

    $('#calendar').fullCalendar({
        defaultDate: moment(),
        lang: timegrid.lang,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'agendaWeek',
        allDayDefault: false,
        allDaySlot: false,
        businessHours: {
            start: timegrid.minTime,
            end: timegrid.maxTime,
            dow: [ 1, 2, 3, 4, 5, 6 ]
        },
        views: {
            agendaWeek: {
                minTime: timegrid.minTime,
                maxTime: timegrid.maxTime,
                slotDuration: timegrid.slotDuration
            }
        },
        events: timegrid.events
    });

});
</script>
@endsection