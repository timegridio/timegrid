@if(count($items))
<div class="panel panel-default">
    <ul class="list-group">
        @each('manager.search._contact', $items, 'contact')
    </ul>
</div>
@endif