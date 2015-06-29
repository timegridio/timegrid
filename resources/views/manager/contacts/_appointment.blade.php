@foreach ($appointments as $appointment)
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">{!! Icon::hand_up() !!}&nbsp;{{ trans('appointments.status.'.$appointment->statusLabel) }}</div>

  <!-- List group -->
  <ul class="list-group">
    <li class="list-group-item">
        {!! Icon::home() !!}&nbsp;{{ $appointment->business->name }} 
    </li>
    <li class="list-group-item">
        {!! Icon::calendar() !!}&nbsp;{{ $appointment->start_at->toDateString() }} 
    </li>
    <li class="list-group-item">
      <span title="{{ $appointment->tz }}">
        {!! Icon::time() !!}&nbsp;{{ $appointment->start_at->timezone($appointment->tz)->toTimeString() }}&nbsp;{{ trans('appointments.text.to') }}&nbsp;{{ $appointment->finish_at->timezone($appointment->tz)->toTimeString() }}
      </span>
    </li>
    <li class="list-group-item">
        {!! Icon::hourglass() !!}&nbsp;{{ $appointment->duration }}&nbsp;{{ trans('appointments.text.minutes') }}
    </li>
  </ul>

  <div class="panel-body">
    <p>{{ $appointment->comments }}</p>
  </div>

  <div class="panel-footer">{!! Icon::barcode() !!}&nbsp;{{ $appointment->code }}</div>
</div>
@endforeach