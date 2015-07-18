@if(count($items))
<div class="panel panel-default">
  <div class="panel-heading">Turnos ({{ count($items) }})</div>

    <ul class="list-group">
    @foreach ($items as $key => $item)
        @include('manager.search._appointment', ['appointment' => $item])
    @endforeach
    </ul>
</div>
@endif