<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">{{ $appointment->statusLabel }}</div>
  <div class="panel-body">
    <p>{{ $appointment->comments }}</p>
  </div>

  <!-- List group -->
  <ul class="list-group">
    <li class="list-group-item">{!! Icon::calendar() !!} {{ $appointment->date }}</li>
    <li class="list-group-item">{!! Icon::time() !!} {{ $appointment->time }}</li>
    <li class="list-group-item">{!! Icon::hourglass() !!} {{ $appointment->finishTime }}</li>
  </ul>

  <div class="panel-footer">{!! Icon::barcode() !!} {{ $appointment->code }}</div>
</div>