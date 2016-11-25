<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ isset($business) ? $business->name . ' / ' : '' }}{{ trans('app.name') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    
    <link rel="manifest" href="/manifest.json">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

@yield('css')

@yield('headscripts')

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
    {!! Analytics::render() !!}

    @include('_github-forkme')

    <div class="wrapper">

        @include('cookieConsent::index')

        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ route('home') }}" class="navbar-brand">time<b>grid</b></a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @include('_navi18n')
                            @include('user._navmenu')
                        </ul>
                        <!-- Search input here -->
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- Notifications Menu -->
                            @if(!auth()->guest())
                            @include('user._notifications-menu')

                            <!-- User Account Menu -->
                            @include('_user-account-menu')
                            @endif

                        </ul>
                    </div>
                    <!-- /.navbar-custom-menu -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>
        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="container">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        @yield('title', '')
                        <small>@yield('subtitle', '')</small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">

                    @include('flash::message')
                    @include('_errors')

                    @yield('content')

                </section>
                <!-- /.content -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->

        @include('_footer')

        <!-- /.container -->
    </footer>
</div>
<!-- ./wrapper -->

<!-- Scripts -->
<script src="{{ asset('js/app.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.btn').tooltipster({animation: "grow", theme: 'tooltipster-light'});
    });
</script>

@stack('footer_scripts')

</body>
</html>
