<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('app.nav.user.business.menu') }} <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="{{ route('user.businesses.home') }}">{{ trans('app.nav.user.business.home') }}</a></li>
		<li><a href="{{ route('user.businesses.list') }}">{{ trans('app.nav.user.business.selector') }}</a></li>
		<li><a href="{{ route('user.businesses.suscriptions') }}">{{ trans('app.nav.user.business.my_suscriptions') }}</a></li>
		<li class="nav-divider"></li>
		<li><a href="{{ route('user.booking.list') }}">{{ trans('app.nav.user.business.my_appointments') }}</a></li>
        <li class="nav-divider"></li>
        <li><a href="{{ route('manager.business.index') }}">{{ trans('app.nav.manager.business.register') }}</a></li>
	</ul>
</li>