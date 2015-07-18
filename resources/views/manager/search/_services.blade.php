@if(count($items))
<div class="panel panel-default">
  <div class="panel-heading">Servicios ({{ count($items) }})</div>

    <ul class="list-group">
    @foreach ($items as $key => $item)
        @include('manager.search._service', ['service' => $item])
    @endforeach
    </ul>
</div>
@endif