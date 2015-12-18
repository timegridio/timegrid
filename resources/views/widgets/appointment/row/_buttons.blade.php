<span class="btn-group">

    @if($appointment->isAnnulableBy(auth()->user()->id))
        {!! Button::danger()->withIcon(Icon::remove())->small()->withAttributes([
            'data-action' => 'annulate',
            'class' => 'action',
            'data-business' => $appointment->business->id,
            'data-appointment' => $appointment->id,
            'data-code' => $appointment->code
        ]) !!}
    @endif

    @if($appointment->isConfirmableBy(auth()->user()->id))
        {!! Button::success()->withIcon(Icon::ok())->small()->withAttributes([
            'data-action' => 'confirm',
            'class' => 'action',
            'data-business' => $appointment->business->id,
            'data-appointment' => $appointment->id,
            'data-code' => $appointment->code
        ]) !!}
    @endif

    @if($appointment->isServeableBy(auth()->user()->id))
        {!! Button::normal()->withIcon(Icon::ok())->small()->withAttributes([
            'data-action' => 'serve',
            'class' => 'action',
            'data-business' => $appointment->business->id,
            'data-appointment' => $appointment->id,
            'data-code' => $appointment->code
        ]) !!}
    @endif

</span>
