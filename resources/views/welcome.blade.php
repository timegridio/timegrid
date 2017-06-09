<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{trans('app.name')}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
    
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">

    <link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <link rel="manifest" href="/manifest.json">

    <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Montserrat);
    @import url(https://fonts.googleapis.com/css?family=Arvo);

    h1 {font-family: 'Montserrat', sans-serif;}
    .jumbotron {
        color:#fff;
        background-color: #367FA9;
    }
	.image-container {
		position: relative;
		display: inline-block;
		width: 100px;
		height: 100px;
		background-size: cover;
		background-position: center center;
		border-radius: 4px;
	}
    #inspire {font-family: 'Arvo', serif;}
    .panel{
    	text-align: center;
    	border: none;
    	box-shadow: none;
    }
    </style>

</head>
<body>

    {!! Analytics::render() !!}

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
                {!! Button::success(trans('welcome.jumbotron.btn.begin'))->asLinkTo( url('/register') ) !!}
                {!! Button::normal(trans('welcome.jumbotron.btn.login'))->asLinkTo( url('/login') ) !!}
            	</span>
        	</div>
        </div>
    </header>

    <!-- Features -->
    <div class="row">

        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail panel">
            	<div class="image-container" style="background-image:url('{{asset('img/jumbo/optimize.png')}}')"></div>
                <div class="caption">
                    <h3>{{trans('welcome.feature.1.title')}}</h3>
                    <p>{{trans('welcome.feature.1.content')}}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail panel">
            	<div class="image-container" style="background-image:url('{{asset('img/jumbo/contact.png')}}')"></div>
                <div class="caption">
                    <h3>{{trans('welcome.feature.2.title')}}</h3>
                    <p>{{trans('welcome.feature.2.content')}}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail panel">
            	<div class="image-container" style="background-image:url('{{asset('img/jumbo/do.png')}}')"></div>
                <div class="caption">
                    <h3>{{trans('welcome.feature.3.title')}}</h3>
                    <p>{{trans('welcome.feature.3.content')}}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail panel">
            	<div class="image-container" style="background-image:url('{{asset('img/jumbo/love.png')}}')"></div>
                <div class="caption">
                    <h3>{{trans('welcome.feature.4.title')}}</h3>
                    <p>{{trans('welcome.feature.4.content')}}</p>
                </div>
            </div>
        </div>

    </div><!-- /.row -->
</div>
</body>
<!-- Scripts -->
<script src="{{ asset('js/app.min.js') }}"></script>
<script>
    $(document).ready(function () {

        $('.lang').on('click', function(){

            sessionStorage.language = $(this).data('lang');
        });

        if (typeof(Storage) !== "undefined") {
            if (sessionStorage.language) {
                $('#myModal').modal('hide');
            } else {
                $('#myModal').modal('show');
            }
        } else {
            alert('storage does not work on this browser');
        }
    });

</script>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Select a Language</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    @foreach ($availableLanguages as $locale => $language)
                            <div class="col-md-3 text-center">
                                {!! link_to_route('lang.switch', $language, $locale, ['class' => 'lang', 'data-lang' => $locale]) !!}
                            </div>
                    @endforeach

                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>
</div>
</html>
