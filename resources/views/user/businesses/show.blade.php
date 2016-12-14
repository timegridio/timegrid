@extends('layouts.user')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">

                <div class="panel-heading">
                    {!! Icon::star() !!}&nbsp;{{ $business->subscriptionsCount }}
                </div>

                    <ul class="list-group">

                        <li class="list-group-item text-center">
                            <h1>{!! $business->name !!}</h1>
                        </li>

                        <li class="list-group-item">
                            {!! $business->industryIcon !!}
                        </li>

                        <li class="list-group-item">
                            <div class="row">
                            <div class="col-md-12">
                                <div class="media">
                                  <div class="media-left media-top hidden-xs hidden-sm">
                                    <a href="#">{!! $business->facebookImg('normal') !!}</a>
                                  </div>
                                  <div class="media-body">
                                    <div class="{{ $business->pref('description_div_class') }}">
                                        <h5>{!! Markdown::convertToHtml(strip_tags($business->description)) !!}</h5>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            </div>
                        </li>

                        @if ($business->phone || $business->postal_address)
                        <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-4">
                                    @if ($business->pref('show_phone') && $business->phone)
                                        {!! Icon::phone() !!}&nbsp;{{ $business->phone }}
                                    @endif
                                    </div>
                                    <div class="col-md-8">
                                    @if ($business->pref('show_postal_address') && $business->postal_address)
                                        {!! Icon::home() !!}&nbsp;{{ $business->postal_address }}
                                    @endif
                                    </div>
                                </div>
                        </li>
                        @endif

                        @if ($business->pref('show_map') && $business->postal_address)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    {!! $business->staticMap(11) !!}
                                </div>
                            </div>
                        </li>
                        @endif

                        @if (!($appointment and $appointment->isActive()))
                        <li class="list-group-item">
                            @if ($user->getContactSubscribedTo($business->id) === null)
                                {!! Button::large()->primary(trans('user.business.btn.subscribe_to', ['business' => $business->name]))
                                                   ->asLinkTo(route('user.business.contact.create', $business))
                                                   ->withIcon(Icon::star())->block() !!}
                            @else
                                @if($available)
                                    {!! Button::large()->success(trans('user.appointments.btn.book'))
                                                       ->asLinkTo(route('user.booking.book', $business))
                                                       ->withIcon(Icon::calendar())->block() !!}
                                @else
                                    <div class="alert alert-warning">{{ trans('user.appointments.alert.no_vacancies') }}</div>
                                @endif
                            @endif
                        </li>
                        @endif

                        @if($user->isOwner($business->id))
                        <li class="list-group-item">
                            {!! Button::primary(trans('user.go_to_business_dashboard', ['business' => $business->name]))->withIcon(Icon::dashboard())->block()->large()->asLinkTo(route('manager.business.show', $business), $business->name) !!}
                        </li>
                        @endif

                    </ul>
                
            </div>

            @if ($appointment)
            {!! Form::open(['id' => 'postAppointmentStatus', 'method' => 'post', 'route' => ['api.booking.action']]) !!}
                {!! $appointment->panel !!}
            {!! Form::close() !!}
            @endif

        </div>
    </div>
</div>
@endsection

@push('footer_scripts')
<script>
$(document).ready(function(){

function prepareEvents(){

        console.log('prepareEvents()');

        var form = $('#postAppointmentStatus');
        var button = $('.action');
        var buttons = $('.actiongroup');
        var token = $('input[name=_token]');

        button.click(function (event){

        event.preventDefault();

        var business = $(this).data('business');
        var appointment = $(this).data('appointment');
        var action = $(this).data('action');
        var code = $(this).data('code');
        var panel = $('#'+code);

        $(this).parent().hide();

            $.ajax({
                url: form.attr('action'),
                method: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                data: { business: business, appointment: appointment, action: action, widget: 'panel' }
            }).done(function (data) {
                    console.log('AJAX Done');
                    $('#'+code).replaceWith(data.html);
            }).fail(function (data) {
                    console.log('AJAX Fail');
            }).always(function (data) {
                    $(this).parent().show();
                    // prepareEvents();
                    console.log('AJAX Finish');
                    console.log(data);
            });
        });
    }

prepareEvents();

});
</script>
@endpush