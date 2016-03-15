@extends('layouts.app')

@section('content')
{!! Form::open(['id' => 'postAppointmentStatus', 'method' => 'post', 'route' => ['api.booking.action']]) !!}
<div class="container">
    <div class="panel panel-default">

        <div class="panel-heading">{{ trans('user.appointments.index.title') }}</div>

        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><span class="hidden-md">{!! Icon::asterisk() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.status') }}</span></th>
                        <th><span class="hidden-md">{!! Icon::calendar() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.calendar') }}</span></th>
                        <th><span class="hidden-md">{!! Icon::time() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.start_time') }}</span></th>
                        <th><span class="hidden-md">{!! Icon::time() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.finish_time') }}</span></th>
                        <th><span class="hidden-md">{!! Icon::hourglass() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.duration') }}</span></th>
                        <th><span class="hidden-md">{!! Icon::tag() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.service') }}</span></th>
                        <th><span class="hidden-md">{!! Icon::user() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.contact') }}</span></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                    <tr id="{{ $appointment->code }}">
                        <td>&nbsp;<code>{!! Icon::barcode() !!}&nbsp;{{ $appointment->code }}</code>&nbsp;{!! $appointment->statusIcon !!}</td>
                        <td>{{ $appointment->date('d/M') }}</td>
                        <td title="{{ $appointment->start_at->diffForHumans() }}">{{ $appointment->time }}</td>
                        <td title="{{ $appointment->tz }}">{{ $appointment->finishTime }}</td>
                        <td>{{ $appointment->duration() }}</td>
                        <td>{{ $appointment->service ? $appointment->service->name : '' }}</td>
                        <td>{{ $appointment->contact->fullname }}</td>
                        <td>
                        @include('widgets.appointment.row._buttons', ['appointment' => $appointment, 'user' => $appointment->contact->user])
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
{!! Form::close() !!}
@endsection

{{-- ToDo: Reusable code with app/resources/views/user/appointments/dateslot/show.blade.php --}}
@section('footer_scripts')
@parent
<script>
$(document).ready(function(){

function prepareEvents(){

        console.log('prepareEvents()');

        var form = $('#postAppointmentStatus');
        var button = $('.action');
        var buttons = $('.actiongroup');
        var token = $('input[name=_token]');

        button.click(function (event){

        event.preventDefault();

        var business = $(this).data('business');
        var appointment = $(this).data('appointment');
        var action = $(this).data('action');
        var code = $(this).data('code');

        $(this).parent().hide();

            $.ajax({
                url: form.attr('action'),
                method: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                data: { business: business, appointment: appointment, action: action, widget: 'row' }
            }).done(function (data) {
                    console.log('AJAX Done');
                    $('#'+code).replaceWith(data.html);
            }).fail(function (data) {
                    console.log('AJAX Fail');
            }).always(function (data) {
                    $(this).parent().show();
                    prepareEvents();
                    console.log('AJAX Finish');
                    console.log(data);
            });
        });
    }

prepareEvents();

});
</script>
@endsection