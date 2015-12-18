<div class="panel panel-default">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-list-alt"></span>{{trans('app.notifications.title')}}
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <ul class="demo">
                    @foreach ($notifications as $notification)
                    @include('manager.businesses._notification', ['notification' => $notification->toArray()])
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-footer"></div>
</div>
