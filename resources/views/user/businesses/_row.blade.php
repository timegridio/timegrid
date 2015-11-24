@section('css')
@parent
<style>
.bizinfo {
    color: #666;
}
.glyphicon {
    margin-bottom: 4px;
    margin-right: 10px;
    color: #999;
}
</style>
@endsection

<div class="col-xs-2 col-sm-2 col-md-2">
    <a href="{{route('user.businesses.home', ['business' => $business->id])}}">{!! $business->getPresenter()->getFacebookImg('normal') !!}</a>
</div>
<div class="col-xs-10 col-sm-10 col-md-10">
    <h4><a href="{{route('user.businesses.home', ['business' => $business->id])}}">{{ str_limit($business->name, 50) }}</a></h4>
    <div class="bizinfo">
        @if ( $business->postal_address )
            <p title="{{ $business->postal_address }}"><i class="glyphicon glyphicon-map-marker"></i>&nbsp;{{ $business->postal_address }}</p>
        @endif
        @if ( $business->category )
            <p><i class="glyphicon glyphicon-home"></i>&nbsp;{!! trans('app.business.category.'.strtolower($business->category->slug)) !!}</p>
        @endif
        @if ( $business->description )
            <p><i class="glyphicon glyphicon-info-sign"></i>&nbsp;{{ $business->description }}</p>
        @endif
    </div>
</div>
