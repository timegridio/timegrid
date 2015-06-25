<li class="dropdown">					
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('app.nav.user.business.menu') }} <b class="caret"></b></a>
    <ul class="dropdown-menu">
    	<li><a href="{{ action('HomeController@index') }}">{{ trans('app.nav.user.business.home') }}</a></li>
    	<li><a href="{{ action('HomeController@selector') }}">{{ trans('app.nav.user.business.selector') }}</a></li>
    </ul>
</li>