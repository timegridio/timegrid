<li class="dropdown">					
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('app.nav.manager.business.menu') }} <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="{{ route('manager.businesses.index') }}">{{ trans('app.nav.manager.business.list') }}</a></li>
		<li><a href="{{ route('manager.businesses.create') }}">{{ trans('app.nav.manager.business.register') }}</a></li>
	</ul>
</li>