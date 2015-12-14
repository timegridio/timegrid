{{-- Appointment Panel Partial --}}

{{--
    [META] Translation keys for potsky/laravel-localization-helpers -dev
    trans('appointments.status.annulated')
    trans('appointments.status.confirmed')
    trans('appointments.status.reserved')
    trans('appointments.status.served')
--}}
<div class='panel panel-{{ $appointment->statusToCssClass }}' id='{{ $appointment->code }}'>
    <div class='panel-heading'>
        <h3 class='panel-title'>{{ $appointment->status }}</h3>
    </div>

    <div class='panel-body'>
        <ul class="list-group appointmentinfo {{ $appointment->statusToCssClass }}">
            <li class="list-group-item">
                <span class='glyphicon glyphicon-home'></span>&nbsp;
                {{ $appointment->business->name }}
            </li>

            <li class="list-group-item">
                <span class='glyphicon glyphicon-user'></span>&nbsp;
                {{ $appointment->contact->firstname }} {{ $appointment->contact->lasttname }}
            </li>

            <li class="list-group-item">
                <span class='glyphicon glyphicon-calendar'></span>&nbsp;
                {{ $appointment->date }}&nbsp;&nbsp;
                <span class="text-muted">
                    <small>{{ $appointment->diffForHumans }}</small>
                </span>
            </li>

            <li class="list-group-item"><span title="{{ $appointment->tz }}">
                <span class='glyphicon glyphicon-time'></span>&nbsp;
                    {{ $appointment->time }}&nbsp;&nbsp;
                </span>
                <span class="text-muted">
                    <small>{{ $appointment->tz }}</small>
                </span>
            </li>


            <li class="list-group-item">
                <span class='glyphicon glyphicon-tag'></span>&nbsp;{{ $appointment->service->name }}
            </li>

            @if($appointment->comments)
            <li class="list-group-item">
                <span class='glyphicon glyphicon-pen'></span>&nbsp;{{ $appointment->comments }}
            </li>
            @endif
        </ul>

        @include('widgets.appointment.panel._buttons', ['appointment' => $appointment, 'user' => $user])
{{-- BUTTON GROUP
        <span class="btn-group">

        <button class='btn btn-danger action' data-action='annulate' data-appointment='{{ $appointment->id }}' data-business='{{ $appointment->business->id }}' data-code='{{ $appointment->code }}' type='button'>
            <span class='glyphicon glyphicon-remove'></span>
        </button>
        
        <button class='btn btn-success action' data-action='confirm' data-appointment='{{ $appointment->id }}' data-business='{{ $appointment->business->id }}' data-code='{{ $appointment->code }}' type='button'>
            <span class='glyphicon glyphicon-ok'></span>
        </button>

        </span>
--}}
    </div>


    <div class='panel-footer'>
        <span class='glyphicon glyphicon-barcode'></span>&nbsp;<code>{{ $appointment->code }}</code>
    </div>
</div>
{{-- Appointment Panel Partial --}}