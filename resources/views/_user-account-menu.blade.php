<!-- User Account Menu -->
<li class="dropdown user user-menu">
    <!-- Menu Toggle Button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!-- The user image in the navbar-->
        <img src="{{ $gravatarURL }}" class="user-image" alt="{{ $user->name }}">
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs">{{ $user->name }}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- The user image in the menu -->
        <li class="user-header">
            <img src="{{ $gravatarURL }}" class="img-circle" alt="{{ $user->name }}">

            <p title="{{ $timezone }}">{{ $user->name }}</p>
            <p><small>{{ $user->email }}</small></p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="row">
                <div class="col-xs-4 text-center">
                    <a href="{{ route('manager.business.index') }}">{{ trans('app.nav.manager.business.menu') }}</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="#"></a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="{!! env('DOCS_URL', 'http://docs.timegrid.io/') !!}{{ Session::get('language') }}/" target="_blank">{{ trans('app.nav.manual') }}</a>
                </div>
            </div>
            <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="{{ route('user.preferences') }}" class="btn btn-default btn-flat">{{ trans('app.nav.preferences') }}</a>
            </div>
            <div class="pull-right">
                <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">{{ trans('app.nav.logout') }}</a>
            </div>
        </li>
    </ul>
</li>