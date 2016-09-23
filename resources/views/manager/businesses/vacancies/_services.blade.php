<ul class="list-group">
@foreach($times as $time => $availableCapacity)

    @if($availableCapacity === null)
        <li class="list-group-item list-group-item-default">
            {{ $time }}
        </li>
    @elseif($availableCapacity > 0)
        <li title="{{ $date }} {{ $time }} {{ $availableCapacity }}" class="list-group-item list-group-item-success">
            {{ $time }}
        </li>
    @else
        <li title="{{ $date }} {{ $time }} {{ $availableCapacity }}" class="list-group-item list-group-item-danger">
            {{ $time }}
        </li>
    @endif

@endforeach
</ul>