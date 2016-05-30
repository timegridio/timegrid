<div class="row">
    <div class="col-md-12 text-center">
        <a class="btn btn-block btn-social btn-facebook btn-flat" href="{{ route('social.login', ['facebook']) }}"><i class="fa fa-facebook"></i> {{ trans('auth.social.facebook') }}</a>
        <a class="btn btn-block btn-social btn-google btn-flat" href="{{ route('social.login', ['google']) }}"><i class="fa fa-google-plus"></i> {{ trans('auth.social.google') }}</a>
        <a class="btn btn-block btn-social btn-github btn-flat" href="{{ route('social.login', ['github']) }}"><i class="fa fa-github"></i> {{ trans('auth.social.github') }}</a>
    </div>
</div>