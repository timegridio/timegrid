@section('css')
@parent
<style>
.glyphicon {
    margin-bottom: 4px;
    margin-right: 10px;
    color: #999;
}
</style>
@endsection

<div class="row">

    <div class="col-md-2 col-sm-3 text-left">
        <a href="{{route('user.businesses.home', ['business' => $business])}}">
            {!! $business->getPresenter()->getFacebookImg('normal') !!}
        </a>
    </div>

    <div class="col-md-10 col-sm-9">

        <h3>
            <a href="{{route('user.businesses.home', ['business' => $business])}}">
                {{ str_limit($business->name, 50) }}
            </a>
            &nbsp;
            <small class="text-muted">
                <i class="glyphicon glyphicon-star"></i>{{ $business->subscriptionsCount }}
            </small>
        </h3>

        <div class="row">
            <div class="col-xs-9">

                @if ( $business->category )
                    <p>
                        <i class="glyphicon glyphicon-home"></i>&nbsp;
                        {!! trans('app.business.category.'.strtolower($business->category->slug)) !!}
                    </p>
                @endif

                @if ( $business->postal_address )
                    <p title="{{ $business->postal_address }}">
                        <i class="glyphicon glyphicon-map-marker"></i>&nbsp;
                        {{ $business->postal_address }}
                    </p>
                @endif

                @if ( $business->description )
                    <p>
                        <i class="glyphicon glyphicon-info-sign"></i>&nbsp;
                        {{ str_limit($business->description, 80) }}
                    </p>
                @endif

            </div>
            <div class="col-xs-3"></div>
        </div>
    </div>{{-- column --}}

</div>{{-- row --}}