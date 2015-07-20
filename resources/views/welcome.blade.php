<html>
    <head>
        <title>Laravel</title>
        
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>


    </head>
    <body>

   <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>{{ trans('welcome.jumbotron.title') }}</h1>
            <p>{{ trans('welcome.jumbotron.description') }}</p>
            <div class="row">{!! Button::primary(trans('welcome.jumbotron.btn'))->asLinkTo( route('wizard.welcome') ) !!}
        </header>

        <!-- Page Features -->
        <div class="row text-center">

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>{{trans('welcome.feature.1.title')}}</h3>
                        <p>{{trans('welcome.feature.1.content')}}</p>
                        <p>
                            <a href="#" class="btn btn-primary">{{trans('welcome.feature.1.btn.action')}}</a> <a href="#" class="btn btn-default">{{trans('welcome.feature.1.btn.info')}}</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>{{trans('welcome.feature.2.title')}}</h3>
                        <p>{{trans('welcome.feature.2.content')}}</p>
                        <p>
                            <a href="#" class="btn btn-primary">{{trans('welcome.feature.2.btn.action')}}</a> <a href="#" class="btn btn-default">{{trans('welcome.feature.2.btn.info')}}</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>{{trans('welcome.feature.3.title')}}</h3>
                        <p>{{trans('welcome.feature.3.content')}}</p>
                        <p>
                            <a href="#" class="btn btn-primary">{{trans('welcome.feature.3.btn.action')}}</a> <a href="#" class="btn btn-default">{{trans('welcome.feature.3.btn.info')}}</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>{{trans('welcome.feature.4.title')}}</h3>
                        <p>{{trans('welcome.feature.4.content')}}</p>
                        <p>
                            <a href="#" class="btn btn-primary">{{trans('welcome.feature.4.btn.action')}}</a> <a href="#" class="btn btn-default">{{trans('welcome.feature.4.btn.info')}}</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->

    </body>
</html>
