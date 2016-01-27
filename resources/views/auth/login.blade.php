@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('auth.login.title') }}</div>
                <div class="panel-body">
                    @if ($errors->has())
                        <div class="alert alert-danger">
                            <strong>{{ trans('auth.login.alert.whoops') }}</strong> {{ trans('auth.login.alert.message') }}<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                        {!! Button::success(trans('auth.btn.not_registered'))->block()->asLinkTo(url('/auth/register')) !!}<p>&nbsp;</p>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.login.email') }}</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.login.password') }}</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> {{ trans('auth.login.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">{{ trans('auth.login.login') }}</button>

                                <a class="btn btn-link" href="{{ url('/auth/password/reset') }}">{{ trans('auth.login.forgot') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="notRegisteredLink" class="row hidden" style="margin-bottom: 20px;">
				<div class="col-md-12">
				    {!! Button::success(trans('auth.btn.not_registered'))->withAttributes(['id' => 'btnNotRegistered', 'class' => ''])->block()->asLinkTo(url('/auth/register')) !!}
				</div>
            </div>

            @include('auth/social')
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
@parent
<script type="text/javascript">
$(document).ready(function(){
    $('#notRegisteredLink').hide();
    var timer;
    clearTimeout(timer);
    timer = setTimeout(function (event) {
        console.log('Search keypress');
        $('#notRegisteredLink').removeClass('hidden').show('slow');
    }, 10000);
});
</script>
@endsection