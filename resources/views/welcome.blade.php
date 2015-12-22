<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{trans('app.name')}}</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

        <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Montserrat);
        @import url(https://fonts.googleapis.com/css?family=Arvo);
        h1 {font-family: 'Montserrat', sans-serif;}
        .jumbotron {
            color:#fff;
            background-color: #367FA9;
        }
        img {
            filter: none;
            -webkit-filter: grayscale(20%);
            -moz-filter:    grayscale(20%);
            -ms-filter:     grayscale(20%);
            -o-filter:      grayscale(20%);
        }
        img:hover {
            filter: none;
            -webkit-filter: grayscale(0%);
            -moz-filter:    grayscale(0%);
            -ms-filter:     grayscale(0%);
            -o-filter:      grayscale(0%);
        }
        #inspire {font-family: 'Arvo', serif;}
        .panel{
            -o-transition:color .2s ease-out, background 1s ease-in;
            -ms-transition:color .2s ease-out, background 1s ease-in;
            -moz-transition:color .2s ease-out, background 1s ease-in;
            -webkit-transition:color .2s ease-out, background 1s ease-in;
            transition:color .2s ease-out, background 1s ease-in;
        }
        #optimize:hover{background-color: #FFD8CC;}
        #contact:hover{background-color: #FFF0CC;}
        #do:hover{background-color: #E4FFCC;}
        #love:hover{background-color: #FFCCEE;}
        </style>

    </head>
    <body>

   <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>
                <img class="hidden-xs hidden-sm" src="{{ asset('img/timegrid-logo-white.png') }}" />
                {{ trans('welcome.jumbotron.title') }}
            </h1>
            <p class="hidden-xs" id="inspire">{{ trans('welcome.jumbotron.description') }}</p>
            <div class="row">
            	<div class="col-xs-12">
            		<span class="btn-group">
                    {!! Button::success(trans('welcome.jumbotron.btn.begin'))->asLinkTo( url('auth/register') ) !!}
                    {!! Button::normal(trans('welcome.jumbotron.btn.login'))->asLinkTo( url('auth/login') ) !!}
                	</span>
            	</div>
            </div>
        </header>

        <!-- Page Features -->
        <div class="row">

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail panel" id="optimize">
                    <img src="{{asset('img/jumbo/optimize.png')}}" alt="">
                    <div class="caption">
                        <h3>{{trans('welcome.feature.1.title')}}</h3>
                        <p>{{trans('welcome.feature.1.content')}}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail panel" id="contact">
                    <img src="{{asset('img/jumbo/contact.png')}}" alt="">
                    <div class="caption">
                        <h3>{{trans('welcome.feature.2.title')}}</h3>
                        <p>{{trans('welcome.feature.2.content')}}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail panel" id="do">
                    <img src="{{asset('img/jumbo/do.png')}}" alt="">
                    <div class="caption">
                        <h3>{{trans('welcome.feature.3.title')}}</h3>
                        <p>{{trans('welcome.feature.3.content')}}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail panel" id="love">
                    <img src="{{asset('img/jumbo/love.png')}}" alt="">
                    <div class="caption">
                        <h3>{{trans('welcome.feature.4.title')}}</h3>
                        <p>{{trans('welcome.feature.4.content')}}</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->

    </body>
</html>
