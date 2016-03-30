<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('app.nav.user.business.menu') }} <b class="caret"></b></a>
    <ul class="dropdown-menu">
    @if(isset($business))
        <li>
            <a href="{{ route('user.businesses.home', compact('business')) }}">{!! Icon::map_marker() !!}&nbsp;{{ $business->name }}</a>
        </li>
        <li class="nav-divider"></li>
    @endif
        <li>
            <a href="{{ route('user.directory.list') }}">{{ trans('app.nav.user.business.selector') }}</a>
        </li>
        <li>
            <a href="{{ route('user.subscriptions') }}">{{ trans('app.nav.user.business.my_subscriptions') }}</a>
        </li>
        <li class="nav-divider"></li>
        <li>
            <a href="{{ route('user.agenda') }}">{{ trans('app.nav.user.business.my_appointments') }}</a>
        </li>
        <li class="nav-divider"></li>
        <li>
            <a href="{{ route('wizard.welcome') }}">{{ trans('app.nav.wizard') }}</a>
        </li>
    </ul>
</li>