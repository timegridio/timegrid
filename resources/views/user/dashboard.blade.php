@extends('app')

@section('content')
<div class="container">
    <div class="row">

    @if($appointmentsCount = $appointments->count() > 0)
        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail panel">
                <img src="{{asset('img/jumbo/do.png')}}" alt="">
                <div class="caption">
                    <h3>{{trans_choice('user.dashboard.card.agenda.title', $appointmentsCount)}}</h3>
                    <p>{{trans_choice('user.dashboard.card.agenda.description', $appointmentsCount)}}</p>
                    {!! Button::info(trans('user.dashboard.card.agenda.button'))
                        ->large()
                        ->block()
                        ->asLinkTo( route('user.agenda') ) !!}
                </div>
            </div>
        </div>
    @endif

    @if($subscriptionsCount = auth()->user()->contacts->count() > 0)
        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail panel">
                <img src="{{asset('img/jumbo/contact.png')}}" alt="">
                <div class="caption">
                    <h3>{{trans('user.dashboard.card.subscriptions.title', ['count' => $subscriptionsCount])}}</h3>
                    <p>{{trans('user.dashboard.card.subscriptions.description')}}</p>
                    {!! Button::info(trans('user.dashboard.card.subscriptions.button'))
                        ->large()
                        ->block()
                        ->asLinkTo( route('user.subscriptions') )!!}
                </div>
            </div>
        </div>
    @endif

    @if($appointmentsCount + $subscriptionsCount == 0)
        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail panel">
                <img src="{{asset('img/jumbo/love.png')}}" alt="">
                <div class="caption">
                    <h3>{{trans('user.dashboard.card.directory.title')}}</h3>
                    <p>{{trans('user.dashboard.card.directory.description')}}</p>
                    {!! Button::info(trans('user.dashboard.card.directory.button'))
                        ->large()
                        ->block()
                        ->asLinkTo( route('user.directory.list') )!!}
                </div>
            </div>
        </div>
    @endif

    </div>
</div>
@endsection