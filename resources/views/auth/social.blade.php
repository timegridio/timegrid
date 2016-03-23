<div class="row">
    <div class="col-md-12 text-center">
        <p class="text-muted">{{ trans('auth.label.oauth_direct_access') }}</p>
        <a class="btn btn-primary btn-oauth-github" href="{{ route('social.login', ['github']) }}">Github</a>
        <a class="btn btn-primary btn-oauth-facebook" href="{{ route('social.login', ['facebook']) }}">Facebook</a>
        <a class="btn btn-primary btn-oauth-google" href="{{ route('social.login', ['google']) }}">Google</a>
    </div>
</div>