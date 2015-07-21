@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-heading">
                    @if(\Auth::user()->isOwner($business))
                        <h1>{!! Icon::star() !!} {!! link_to(route('manager.business.show', $business), $business->name) !!}</h1>
                    @else
                        <h1>{{ $business->name }}</h1>
                    @endif
                </div>

                    <ul class="list-group">
                        <li class="list-group-item">
                        
                        <div class="row">

                            <div class="col-md-7">
                                <div class="media">
                                  <div class="media-left media-top hidden-xs hidden-sm">
                                    <a href="#">{!! $business->facebookPicture('normal') !!}</a>
                                  </div>
                                  <div class="media-body">
                                    <h4 class="media-heading">{{ $business->name }}</h4>
                                    <blockquote>{!! nl2br(e($business->description)) !!}</blockquote>
                                    @if ($appointment = \Auth::user()->appointments()->where('business_id', $business->id)->oldest()->active()->future()->first())
                                        {!! $appointment->widget()->mini(trans('Te esperamos')) !!}
                                    @endif
                                  </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                            <div class="col-md-12">
                                <div class="row hidden-xs">
                                    <blockquote>{!! Icon::globe() !!}&nbsp;{{ $business->timezone }}</blockquote>
                                </div>
                                <div class="row">
                                    <blockquote>{!! Icon::phone() !!}&nbsp;{{ $business->phone }}</blockquote>
                                </div>
                                <div class="row">
                                    {!! $business->staticMap(11) !!}
                                </div>
                                <div class="row">
                                    <blockquote>{!! Icon::home() !!}&nbsp;{{ $business->postal_address }}</blockquote>
                                </div>
                            </div>
                            </div>

                        </div>
                        
                        </li>

                        @if (!($appointment and $appointment->isActive()))
                        <li class="list-group-item">
                            @if (\Auth::user()->suscribedTo($business) !== null)
                                {!! Button::large()->success(trans('user.appointments.btn.book'))->asLinkTo(route('user.booking.book'))->withIcon(Icon::calendar())->block() !!}
                            @else
                                {!! Button::large()->primary(trans('user.business.btn.suscribe'))->asLinkTo(route('user.business.contact.create', $business))->withIcon(Icon::star())->block() !!}
                            @endif
                        </li>
                        @endif
                    </ul>

                
            </div>
        </div>
    </div>
</div>
@endsection
