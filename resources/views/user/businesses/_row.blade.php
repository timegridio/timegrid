<a href="{{ route('user.businesses.home', compact('business')) }}" class="list-group-item">
    <div class="media col-md-3">
        <figure class="pull-left">
            {!! $business->facebookImg('normal') !!}
        </figure>
    </div>
    <div class="col-md-6">
        <h4 class="list-group-item-heading"> {{ str_limit($business->name, 50) }} </h4>
        <p class="list-group-item-text">
            <p>
                <i class="glyphicon glyphicon-home"></i>&nbsp;
                {!! trans('app.business.category.'.strtolower($business->category->slug)) !!}
            </p>
        </p>
        <p class="list-group-item-text">
            {{ str_limit(strip_tags(Markdown::convertToHtml($business->description)), 400) }}
        </p>
    </div>
    <div class="col-md-3 text-center">
        <h2> {{ $business->subscriptionsCount }} <small> {{ trans('user.businesses.subscriptions.title') }} </small></h2>
        <button type="button" class="btn btn-default btn-lg btn-block"> {{ trans('user.appointments.btn.book') }} </button>
    </div>
</a>
