@if(Session::get('selected.business') && Auth::user()->isOwner(Session::get('selected.business')))
    <li id="navHome"><a href="{{ route('manager.business.show', $business->id) }}">{!! Icon::home() !!} {{ $business->name }}</a></li>
@endif

<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('app.nav.manager.business.menu') }} <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="{{ route('manager.business.index') }}">{{ trans('app.nav.manager.business.list') }}</a></li>
		<li><a href="{{ route('manager.business.create') }}">{{ trans('app.nav.manager.business.register') }}</a></li>
	</ul>
</li>

{!! Form::open(['method' => 'post', 'url' => '/manager/search/', 'class' => 'navbar-form navbar-left', 'role' => 'search']) !!}
<div class="form-group">
  <input id="search" name="criteria" type="text" class="form-control" placeholder="{{trans('app.search')}}">
</div>
{!! Form::close() !!}