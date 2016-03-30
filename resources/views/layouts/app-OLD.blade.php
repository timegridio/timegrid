<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
    <title>{{ isset($business) ? $business->name . ' / ' : '' }}{{trans('app.name')}}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @yield('css')

    @yield('headscripts')

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="skin-blue">
{!! Analytics::render() !!}

@if (config('env') == 'demo')
<a target="_blank" href="https://github.com/alariva/timegrid">
    <img style="position: absolute; top: 0; left: 0; border: 0; z-index:99999" src="https://camo.githubusercontent.com/82b228a3648bf44fc1163ef44c62fcc60081495e/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f6c6566745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_left_red_aa0000.png">
</a>
@endif

<div class="wrapper" id="wrapper">

    <!-- Sidebar -->
    @if(isset($help))
    <a href="#menu-toggle" id="menu-toggle" class="animated bounceInLeft"></a>
    <div id="sidebar-wrapper">
        <div class="container-fluid">
            <div id="userhelp">
            <h1>{{ trans('app.nav.help') }}</h1>
            {!! $help !!}
            </div>
        </div>
    </div>
    @endif
    <!-- /#sidebar-wrapper -->

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">{{ trans('app.name') }}</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @if ($user)
                @include('manager/_navmenu')
                @endif
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @include('user/_navmenu')

                @include('_navi18n')

                @if ($isGuest)
                <li><a href="{{ url('/auth/login') }}">{{ trans('app.nav.login') }}</a></li>
                <li><a href="{{ url('/auth/register') }}">{{ trans('app.nav.register') }}</a></li>
                @else
                <li id="navProfile" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img src="{{ Gravatar::get(auth()->user()->email, ['size' => 24, 'secure' => true]) }}" class="img-circle"> {{ $user->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('manager.business.index') }}">{{ trans('app.nav.manager.business.menu') }}</a></li>
                        <li class="nav-divider"></li>
                        <li><a href="{{ route('user.dashboard') }}">{{ trans('app.nav.dashboard') }}</a></li>
                        <li class="nav-divider"></li>
                        <li><a href="{!! env('DOCS_URL', 'http://docs.timegrid.io/') !!}{{Session::get('language')}}/">{{ trans('app.nav.manual') }}</a></li>
                        <li class="nav-divider"></li>
                        <li><a href="{{ url('/auth/logout') }}">{{ trans('app.nav.logout') }}</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
        @include('flash::message')
        @include('_errors')

        @yield('content')

        </div>
    </div>

</div>

@include('_footer')

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('.btn').tooltipster({animation: "grow", theme: 'tooltipster-light'});

    // Menu Toggle Script
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
});
</script>

@yield('footer_scripts')
</body>
</html>
