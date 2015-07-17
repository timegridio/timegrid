<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Root</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ route('user.businesses.home') }}">Home</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					{{--/ Language Switcher --}}
					<li class="dropdown">					
					    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Config::get('languages')[App::getLocale()] }} <b class="caret"></b></a>
					    <ul class="dropdown-menu">
					        @foreach (Config::get('languages') as $lang => $language)
					            @if ($lang != App::getLocale())
					                <li>
					                    {!! link_to_route('lang.switch', $language, $lang) !!}
					                </li>
					            @endif
					        @endforeach
					    </ul>
					</li>
					{{-- Language Switcher /--}}
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">{{ trans('app.nav.login') }}</a></li>
						<li><a href="{{ url('/auth/register') }}">{{ trans('app.nav.register') }}</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->email }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">{{ trans('app.nav.logout') }}</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	@include('_footer')

	<!-- Scripts -->
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
