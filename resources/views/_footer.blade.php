<footer class="footer">
    <div class="container">
        <p>&nbsp;</p>
        <p class="text-muted" title="v.{{ getenv('APP_VERSION') }}">
            {{trans('app.name')}}
            @if (env('APP_ENV') == 'local')
                <span class="pull-right">{!! Label::danger('LOCAL') !!} <span class="text-danger">&nbsp;{{ trans('app.footer.local') }}</span></span>
            @endif
            @if (env('APP_ENV') == 'demo')
                <span class="pull-right">{!! Label::danger('DEMO') !!} <span class="text-danger">&nbsp;{{ trans('app.footer.demo') }}</span></span>
            @endif
        </p>
    </div>
</footer>