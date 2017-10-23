@extends('layouts.bare')

@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="{{ url('/') }}">time<b>grid</b></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">{{ trans('auth.register.title') }}</p>

        @unless(config('root.app.allow_register_user'))
        <div class="alert alert-danger">
            {{ trans('app.allow_register_user') }}
        </div>
        @endif

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
        {!! Button::success(trans('auth.btn.already_registered'))->block()->asLinkTo(url('/login')) !!}
        @endif
        @if ($errors->has('password'))
        {!! Button::warning(trans('auth.btn.forgot'))->block()->asLinkTo(url('/password/email')) !!}
        @endif
        <p>&nbsp;</p>
        @endif

        <div class="container-fluid">
            <div class="row">
                <form role="form" method="POST" action="{{ url('/register') }}" id="registration" role="form">
                    {{ csrf_field() }}

                    <div class="form-group has-feedback">
                        @if (!app()->environment('local'))
                        {!! app('captcha')->display() !!}
                        @endif
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" name="email" placeholder="{{ trans('auth.register.email') }}" value="{{ old('email') }}" id="email" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group has-feedback">
                        <input class="form-control" name="name" placeholder="{{ trans('auth.register.name') }}" value="{{ old('name') }}" data-minlength="3" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="{{ trans('auth.register.password') }}" id="password" data-minlength="6" placeholder="" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('auth.register.password_confirmation') }}" id="password_confirmation" data-minlength="6" placeholder="" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="submit">
                                {{ trans('auth.register.btn.submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="social-auth-links text-center">
                    <p>{{ trans('auth.label.oauth_direct_access') }}</p>
                    @include('auth/social')
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <a href="{{ url('auth/login') }}" class="text-center">{{ trans('auth.btn.already_registered') }}</a>
    </div>
    <!-- /.register-box-body -->
</div>
<!-- /.register-box -->
@endsection

@push('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>
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
            // #
        }
    });

});
</script>
@endpush