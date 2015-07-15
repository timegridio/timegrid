@extends('app')

@section('content')
{!! Form::open(['id' => 'postAppointmentStatus', 'method' => 'post', 'route' => ['manager.business.agenda.action']]) !!}
{{-- {!! Form::hidden('business_id', null, array('required') ) !!} --}}
{{-- {!! Form::hidden('appointment_id', null, array('required') ) !!} --}}
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('user.appointments.index.title') }}</div>
                    <div class="panel-body">
                        <table class="table table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th><span class="hidden-md">{!! Icon::barcode() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.code') }}</span></th>
                                    <th><span class="hidden-md">{!! Icon::asterisk() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.status') }}</span></th>
                                    <th><span class="hidden-md">{!! Icon::calendar() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.calendar') }}</span></th>
                                    <th><span class="hidden-md">{!! Icon::time() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.start_time') }}</span></th>
                                    <th><span class="hidden-md">{!! Icon::briefcase() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.service') }}</span></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td><code>{{ $appointment->code }}</code></td>
                                    <td>{{ $appointment->status }}</td>
                                    <td>{{ $appointment->start_at->timezone($appointment->tz)->toDateString() }}</td>
                                    <td title="{{ $appointment->tz }}">{{ $appointment->start_at->timezone($appointment->tz)->toTimeString() }}</td>
                                    <td>{{ $appointment->service ? $appointment->service->name : '' }}</td>
                                    <td>{!! Button::danger()->withIcon(Icon::remove())->withAttributes(['class' => 'action', 'type' => 'button', 'data-action' => 'annulate', 'data-business' => $appointment->business->id, 'data-appointment' => $appointment->id]) !!}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection

@section('footer_scripts')
@parent
<script>
$(document).ready(function(){

    var form = $('#postAppointmentStatus');
    var button = $('.action');
    var token = $('input[name=_token]');

    button.click(function (event){

    event.preventDefault();

    var formData = new FormData();
    var business = $(this).data('business');
    var appointment = $(this).data('appointment');
    var action = $(this).data('action');
    // formData.append('business_id', $(this).data('business'));
    // formData.append('appointment_id', $(this).data('appointment'));
    formData.append('_token', token.val());

    console.log(form.serialize());

        $.ajax({
            url: form.attr('action'),
            method: 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            data: { business: business, appointment: appointment, action: action },
            // error: function (data) {
            //     alert('Error');
            // },
            success: function (data) {
                // alert('Success');
            }
        });
    });
});
</script>
@endsection