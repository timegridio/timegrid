<span class="btn-group">

    @if($appointment->isAnnulable())
        {!! Button::danger()->withIcon(Icon::remove())->withAttributes([
            'data-action' => 'annulate',
            'class' => 'action',
            'data-business' => $appointment->business->id,
            'data-appointment' => $appointment->id,
            'data-code' => $appointment->code
        ]) !!}
    @endif

    @if($appointment->isConfirmable())
        {!! Button::success()->withIcon(Icon::ok())->withAttributes([
            'data-action' => 'confirm',
            'class' => 'action',
            'data-business' => $appointment->business->id,
            'data-appointment' => $appointment->id,
            'data-code' => $appointment->code
        ]) !!}
    @endif

@if($appointment->profile($user->id) == 'manager')

    @if($appointment->isServeable())
        {!! Button::normal()->withIcon(Icon::ok())->withAttributes([
            'data-action' => 'serve',
            'class' => 'action',
            'data-business' => $appointment->business->id,
            'data-appointment' => $appointment->id,
            'data-code' => $appointment->code
        ]) !!}
    @endif

@endif

</span>