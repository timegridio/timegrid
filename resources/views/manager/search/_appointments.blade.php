@if(count($items))
<div class="panel panel-default">
    <ul class="list-group">
        @foreach ($items as $key => $item)
            @include('manager.search._appointment', ['appointment' => $item])
        @endforeach
    </ul>
</div>
@endif