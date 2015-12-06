@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">

                <div class="panel-heading">
                        {!! Icon::star() !!}&nbsp;{{ $business->subscriptionsCount }} {{ $business->name }}
                </div>

                    <ul class="list-group">

                        <li class="list-group-item">
                            {!! $business->industryIcon() !!}
                        </li>

                        <li class="list-group-item">
                            <div class="row">
                            <div class="col-md-12">
                                <div class="media">
                                  <div class="media-left media-top hidden-xs hidden-sm">
                                    <a href="#">{!! $business->facebookImg('normal') !!}</a>
                                  </div>
                                  <div class="media-body">
                                    <h4 class="media-heading">{{ $business->name }}</h4>
                                    <blockquote>{!! nl2br(e($business->description)) !!}</blockquote>
                                  </div>
                                </div>
                            </div>
                            </div>
                        </li>

                        @if ($business->pref('show_map') && $business->postal_address)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    {!! $business->staticMap(11) !!}
                                </div>
                            </div>
                        </li>
                        @endif

                        <li class="list-group-item">
                                    {!! Button::large()->success(trans('user.appointments.btn.book'))->asLinkTo(route('user.booking.book', $business))->withIcon(Icon::calendar())->block() !!}
                        </li>

                    </ul>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
@parent
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
                    prepareEvents();
                    console.log('AJAX Finish');
                    console.log(data);
            });
        });
    }

prepareEvents();

});
</script>
@endsection