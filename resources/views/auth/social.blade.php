<div class="row">
    <div class="col-md-12 text-center">
        <p class="text-muted">{{ trans('auth.label.oauth_direct_access') }}</p>
        <a class="btn btn-primary btn-oauth-github" href="{{ route('social.login', ['github']) }}">{{ trans('auth.social.github') }}</a>
        <a class="btn btn-primary btn-oauth-facebook" href="{{ route('social.login', ['facebook']) }}">{{ trans('auth.social.facebook') }}</a>
        <a class="btn btn-primary btn-oauth-google" href="{{ route('social.login', ['google']) }}">{{ trans('auth.social.google') }}</a>
    </div>
</div>