@extends('layouts.bare')

@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/iCheck/icheck.min.css') }}">
@endsection

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}">time<b>grid</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">{{ trans('auth.login.title') }}</p>

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{ trans('auth.login.alert.whoops') }}</strong> {{ trans('auth.login.alert.message') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        {!! Button::success(trans('auth.btn.not_registered'))->block()->asLinkTo(url('/register')) !!}<p>&nbsp;</p>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="{{ trans('auth.login.email') }}" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="{{ trans('auth.login.password') }}" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">

                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> {{ trans('auth.login.remember_me') }}
                        </label>
                    </div>

                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('auth.login.login') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <div class="social-auth-links text-center">
            <p>- {{ trans('auth.label.oauth_direct_access') }} -</p>
            @include('auth/social')
        </div>
        <!-- /.social-auth-links -->

        <a class="btn btn-link" href="{{ url('/password/reset') }}">{{ trans('auth.login.forgot') }}</a><br>

        <div id="notRegisteredLink" class="row hidden" style="margin-top: 20px;">
            <div class="col-md-12">
                {!! Button::success(trans('auth.btn.not_registered'))->withAttributes(['id' => 'btnNotRegistered', 'class' => ''])->block()->asLinkTo(url('/register')) !!}
            </div>
        </div>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection

@push('footer_scripts')
<script src="{{ asset('js/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('#notRegisteredLink').hide();
        var timer;
        clearTimeout(timer);
        timer = setTimeout(function (event) {
            console.log('Search keypress');
            $('#notRegisteredLink').removeClass('hidden').show('slow');
        }, 10000);

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

    });
</script>
@endpush