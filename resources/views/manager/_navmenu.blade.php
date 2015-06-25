<li class="dropdown">					
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('app.nav.manager.business.menu') }} <b class="caret"></b></a>
    <ul class="dropdown-menu">
    	<li><a href="{{ action('BusinessesController@index') }}">{{ trans('app.nav.manager.business.list') }}</a></li>
    	<li><a href="{{ action('BusinessesController@create') }}">{{ trans('app.nav.manager.business.register') }}</a></li>
    </ul>
</li>