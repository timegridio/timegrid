@extends('layouts.user')

@section('css')
@parent
<style>
.glyphicon {
    margin-bottom: 4px;
    margin-right: 10px;
    color: #999;
}
a.list-group-item {
    height:auto;
    min-height:220px;
}
a.list-group-item.active small {
    color:#fff;
}
.list-group-item-heading {
    margin-top: 16px;
}

.multiline-list-item {
    word-wrap: break-word;
}
</style>
@endsection

@section('title', trans('user.businesses.index.title'))

@section('content')
<div class="container-fluid">
    <div class="row">
        
        <div class="list-group">
            @if ($businesses->isEmpty())
                {{ trans('user.businesses.list.no_businesses') }}
            @else
                @foreach ($businesses as $business)
                    @include('user.businesses._row', compact('business'))
                @endforeach
            @endif
        </div>

        @if($user->hasBusiness())
            {!! Button::normal(trans('user.businesses.index.btn.manage'))->asLinkTo( route('manager.business.index') )->block() !!}
        @else
            {!! Button::primary(trans('user.businesses.index.btn.create'))->asLinkTo( route('manager.business.register') )->block() !!}
        @endif

    </div>
</div>
@endsection