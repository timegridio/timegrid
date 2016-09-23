@if(count($items))
<div class="panel panel-default">
    <ul class="list-group">
        @each('manager.search._service', $items, 'service')
    </ul>
</div>
@endif