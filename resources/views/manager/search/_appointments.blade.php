@if(count($items))
<div class="panel panel-default">
    <ul class="list-group">
        @each('manager.search._appointment', $items, 'appointment')
    </ul>
</div>
@endif