<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">{!! Icon::hand_up() !!}&nbsp;{{ trans('appointments.status.'.$appointment->statusLabel) }}</div>
  <div class="panel-body">
    <p>{{ $appointment->comments }}</p>
  </div>

  <!-- List group -->
  <ul class="list-group">
  </ul>
    <li class="list-group-item">
        <span title="{{ $appointment->tz }}">{!! Icon::calendar() !!}&nbsp;{{ $appointment->TZDate }} 
        {!! Icon::time() !!}&nbsp;{{ $appointment->TZTime }} 
        &nbsp;{{ trans('appointments.text.to') }}&nbsp;
        {{ $appointment->finishTime }}</span>&nbsp;
        {!! Icon::hourglass() !!}&nbsp;{{ $appointment->duration }}&nbsp;
        {{ trans('appointments.text.minutes') }}
    </li>

  <div class="panel-footer">{!! Icon::barcode() !!}&nbsp;{{ $appointment->code }}</div>
</div>