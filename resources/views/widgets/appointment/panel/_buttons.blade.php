<span class="btn-group">

    @if($appointment->isCancelableBy(auth()->id()))
        {!! Button::danger()->withIcon(Icon::remove())->withAttributes([
            'data-action' => 'cancel',
            'class' => 'action',
            'data-business' => $appointment->business->id,
            'data-appointment' => $appointment->id,
            'data-code' => $appointment->code
        ]) !!}
    @endif

    @if($appointment->isConfirmableBy(auth()->id()))
        {!! Button::success()->withIcon(Icon::ok())->withAttributes([
            'data-action' => 'confirm',
            'class' => 'action',
            'data-business' => $appointment->business->id,
            'data-appointment' => $appointment->id,
            'data-code' => $appointment->code
        ]) !!}
    @endif

    @if($appointment->isServeableBy(auth()->id()))
        {!! Button::normal()->withIcon(Icon::ok())->withAttributes([
            'data-action' => 'serve',
            'class' => 'action',
            'data-business' => $appointment->business->id,
            'data-appointment' => $appointment->id,
            'data-code' => $appointment->code
        ]) !!}
    @endif

</span>