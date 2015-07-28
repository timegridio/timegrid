@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">

                <div class="panel-heading">
                    @if(\Auth::user()->isOwner($business))
                        {!! Icon::star() !!} {!! link_to(route('manager.business.show', $business), $business->name) !!}
                    @else
                        {{ $business->name }}
                    @endif
                </div>

                    <ul class="list-group">

                        <li class="list-group-item">
                            {{ trans_choice('user.business.suscriptions_count', $business->suscriptionsCount) }}
                        </li>

                        <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Icon::globe() !!}&nbsp;{{ $business->timezone }}
                                    </div>
                                    <div class="col-md-4">
                                    @if ($business->pref('show_phone') && $business->phone)
                                        {!! Icon::phone() !!}&nbsp;{{ $business->phone }}
                                    @endif
                                    </div>
                                    <div class="col-md-4">
                                    @if ($business->pref('show_postal_address') && $business->postal_address)
                                        {!! Icon::home() !!}&nbsp;{{ $business->postal_address }}
                                    @endif
                                    </div>
                                </div>
                        </li>

                        <li class="list-group-item">
                        
                        <div class="row">

                            <div class="col-md-12">
                                <div class="media">
                                  <div class="media-left media-top hidden-xs hidden-sm">
                                    <a href="#">{!! $business->facebookPicture('normal') !!}</a>
                                  </div>
                                  <div class="media-body">
                                    <h4 class="media-heading">{{ $business->name }}</h4>
                                    <blockquote>{!! nl2br(e($business->description)) !!}</blockquote>
                                    @if ($appointment = \Auth::user()->appointments()->where('business_id', $business->id)->oldest()->active()->future()->first())
                                        {!! Widget::AppointmentPanel(['appointment' => $appointment, 'user' => \Auth::user()]) !!}
                                    @endif
                                  </div>
                                </div>
                            </div>

                            @if ($business->pref('show_map'))
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    {!! $business->staticMap(11) !!}
                                </div>
                            </div>
                            @endif

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
