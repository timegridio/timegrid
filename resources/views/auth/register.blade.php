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

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.register.name') }}</label>
                            <div class="col-md-6">
                                <input class="form-control" name="name" value="{{ old('name') }}" id="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.register.email') }}</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.register.password') }}</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.register.password_confirmation') }}</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" id="confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" id="submit">
                                    {!! Icon::ok()->withAttributes(['id' => 'okicon', 'class' => 'hidden']) !!}
                                    {{ trans('auth.register.btn.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="panel-footer">
                        <div class="progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="progress">
                            0%
                          </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
@parent
<script type="text/javascript">
function enableButton(button, enable)
{
    var icon = $('#okicon');
    if (enable) {
        icon.removeClass('hidden');
        icon.show();
        button.addClass('btn-success');
        button.removeClass('btn-primary');
    }
    else
    {
        icon.hide();
        button.addClass('btn-primary');
        button.removeClass('btn-success');
    }
}

function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return email != '' && emailReg.test( email );
}

function validatePasswords(password, confirmation)
{
    return password.length >= 6 && password == confirmation;
}

function updateProgress(progress, p)
{
    progress.attr('style', 'width:'+p+'%');
    progress.attr('aria-valuenow', p);
    progress.text(p+'%');
    if(p == 100) {
        progress.addClass('progress-bar-success')
    } else {
        progress.removeClass('progress-bar-success') 
    }
}

$(document).ready(function(){

        var button = $('#submit');
        var progress = $('#progress');

        $('input').keyup(function(e){
            /* Ignore tab key */
            var code = e.keyCode || e.which;
            if (code == '9') return;

            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var confirmation = $('#confirmation').val();
            var emailvalidation = validateEmail(email);
            var pwvalidation = validatePasswords(password, confirmation);
            
            p = (0.25*(name.length > 2) + 0.25*(emailvalidation) + 0.25*(password.length >= 6) + 0.25*(pwvalidation))*100;
            
            updateProgress(progress, p);
            enableButton (button, p == 100);
        });
        enableButton (button, false);
});
</script>>
@endsection