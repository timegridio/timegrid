{{-- Appointment Panel Partial --}}

{{--
    [META] Translation keys for potsky/laravel-localization-helpers -dev
    trans('appointments.status.canceled')
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
                <span class='glyphicon glyphicon-user'></span>&nbsp;
                {{ $appointment->contact->firstname }} {{ $appointment->contact->lastname }}
            </li>

            <li class="list-group-item">
                <span class='glyphicon glyphicon-tag'></span>&nbsp;{{ $appointment->service->name }}
            </li>

            <li class="list-group-item">
                <span class='glyphicon glyphicon-home'></span>&nbsp;
                {{ $appointment->business->name }}
            </li>

            @if($appointment->location)
            <li class="list-group-item">
                <span class='glyphicon glyphicon-map-marker'></span>&nbsp;
                {{ $appointment->location }}
            </li>
            @endif

            @if($appointment->phone)
            <li class="list-group-item">
                <span class='glyphicon glyphicon-phone'></span>&nbsp;
                {{ $appointment->phone }}
            </li>
            @endif

            <li class="list-group-item">
                <span class='glyphicon glyphicon-calendar'></span>&nbsp;
                {{ $appointment->date }}&nbsp;&nbsp;
                <span class="text-muted">
                    <small>{{ $appointment->start_at->diffForHumans() }}</small>
                </span>
            </li>

            <li class="list-group-item"><span title="{{ $appointment->tz }}">
                <span class='glyphicon glyphicon-time'></span>&nbsp;
                    {{ trans_choice('appointments.text.arrive_at', count($arriveAt = $appointment->arriveAt), $arriveAt) }}&nbsp;&nbsp;
                    @if($appointment->duration)
                            <span class="text-muted">
                                <span class='glyphicon glyphicon-hourglass'></span>&nbsp;
                                {{ trans_duration($appointment->duration()) }}&nbsp;
                            </span>
                        </span>
                    @endif
                </span>
            </li>

            @if($appointment->comments)
            <li class="list-group-item">
                <span class='glyphicon glyphicon-pencil'></span>&nbsp;{{ $appointment->comments }}
            </li>
            @endif
        </ul>

        @if($appointment->isActive() && $appointment->cancellationDeadline->isPast())
            {!! Alert::warning(trans('appointments.advice.cancellation_deadline_past_due')) !!}
        @endif

        @if(($cancellationPolicyAdvice = $appointment->business->pref('cancellation_policy_advice')) && $appointment->isCancelable() && $appointment->cancellationDeadline->isFuture())
            {!! Alert::warning(sprintf($cancellationPolicyAdvice, $appointment->cancellationDeadline)) !!}
        @endif

        @include('widgets.appointment.panel._buttons', ['appointment' => $appointment, 'user' => $user])

    </div>

    <div class='panel-footer'>
        <span class='glyphicon glyphicon-barcode'></span>&nbsp;<code>{{ $appointment->code }}</code>
    </div>
</div>
{{-- Appointment Panel Partial --}}