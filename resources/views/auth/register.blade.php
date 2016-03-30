@extends('layouts.public')

@section('content')
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">{{ trans('auth.register.title') }}</p>

    @if (isset($errors) && $errors->has())
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
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">

        <div class="form-group has-feedback">
            <input class="form-control" name="name" placeholder="{{ trans('auth.register.name') }}" value="{{ old('name') }}" data-minlength="3" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <input type="text" class="form-control" name="username" placeholder="{{ trans('auth.register.username') }}" value="{{ old('username') }}" id="email" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="{{ trans('auth.register.email') }}" value="{{ old('email') }}" id="email" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="{{ trans('auth.register.password') }}" id="password" data-minlength="6" placeholder="" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('auth.register.password_confirmation') }}" id="password_confirmation" data-minlength="6" placeholder="" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                @if (!app()->environment('local'))
                    {!! app('captcha')->display() !!}
                @endif
                <button type="submit" class="btn btn-primary" id="submit">
                    {{ trans('auth.register.btn.submit') }}
                </button>
            </div>
        </div>
    </form>

    <div class="social-auth-links text-center">
      <p>- {{ trans('auth.label.oauth_direct_access') }} -</p>
      @include('auth/social')
    </div>

    <a href="login.html" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
@endsection

@section('footer_scripts')
<script src="{{asset('js/forms.js')}}"></script>
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
            // #
        }
    });
});
</script>
@endsection