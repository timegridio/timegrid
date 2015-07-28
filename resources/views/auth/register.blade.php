@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('auth.register.title') }}</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>{{ trans('auth.login.alert.whoops') }}</strong> {{ trans('auth.login.alert.message') }}<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @if ($errors->has('email'))
                            {!! Button::success(trans('auth.btn.already_registered'))->block()->asLinkTo(url('/auth/login')) !!}
                        @endif
                        @if ($errors->has('password'))
                            {!! Button::warning(trans('auth.btn.forgot'))->block()->asLinkTo(url('/password/email')) !!}
                        @endif
                        <p>&nbsp;</p>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}" id="registration" role="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.register.name') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">{!! Icon::user() !!}</span>
                                    <input class="form-control" name="name" value="{{ old('name') }}" data-minlength="3" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">{{ trans('auth.register.email') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">{!! Icon::envelope() !!}</span>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.register.password') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">{!! Icon::lock() !!}</span>
                                    <input type="password" class="form-control" name="password" id="password" data-minlength="6" placeholder="{{trans('validation.custom.password.min', ['min'=>'6'])}}" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.register.password_confirmation') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">{!! Icon::lock() !!}</span>
                                    <input type="password" class="form-control" name="password_confirmation" data-match="#password" data-match-error="{{trans('validation.custom.password.confirmed')}}" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                @if (env('APP_ENV') != 'local')
                                    {!! app('captcha')->display() !!}
                                @endif
                                <button type="submit" class="btn btn-primary" id="submit">
                                    {{ trans('auth.register.btn.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script src="{{asset('js/bootstrap-validator.min.js')}}"></script>
@parent
<script type="text/javascript">
$(document).ready(function(){
    
    var count = 0;
    $('#submit').click(function(){
        count++;
        if(count == 5) {
            var script = document.createElement( 'script' );
            script.type = 'text/javascript';
            script.src = '{{ TidioChat::src() }}';
            $("body").append( script );
            alert('{!! trans('auth.register.need_help') !!}');
        }
    });

    $('#registration').validator({
        feedback: {
          success: 'glyphicon-ok',
          error: 'glyphicon-remove'
        },
        errors: {
          match: '{{trans('validation.custom.password.confirmed')}}',
          minlength: '{{trans('validation.custom.name.min')}}'
        }
    });
});
</script>
@endsection