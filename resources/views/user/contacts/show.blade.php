@extends('layouts.user')

@section('css')
<style>
.user-row {
    margin-bottom: 14px;
}

.user-row:last-child {
    margin-bottom: 0;
}

.dropdown-user {
    margin: 13px 0;
    padding: 5px;
    height: 100%;
}

.dropdown-user:hover {
    cursor: pointer;
}

.table-user-information > tbody > tr:first-child {
    border-top: 0;
}

.table-user-information > tbody > tr > td {
    border-top: 0;
}
.toppad
{
    margin-top:20px;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    {!! Form::open(['id' => 'postAppointmentStatus', 'method' => 'post', 'route' => ['api.booking.action']]) !!}

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad">

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $contact->fullname }}</h3>
                </div>

{{--
    [META] Translation keys for potsky/laravel-localization-helpers -dev
    trans('app.gender.F')
    trans('app.gender.M')
--}}

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center">
                            @if($contact->email)
                            <img alt="{{$contact->fullname}}" src="{{ Gravatar::get($contact->email) }}" class="img-circle" />
                            @endif
                            <p>&nbsp;</p>
                            <small>{{ trans('app.gender.'.$contact->gender) }} {{ $contact->age or '' }}</small>
                        </div>

                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-user-information">
                                <tbody>
                                    @if ($contact->email)
                                    <tr>
                                        <td class="text-right"><label class="control-label">{{ trans('manager.contacts.label.email') }}</label></td>
                                        <td>{{ $contact->email }}</td>
                                    </tr>
                                    @endif
                                    @if ($contact->nin)
                                    <tr>
                                        <td class="text-right"><label class="control-label">{{ trans('manager.contacts.label.nin') }}</label></td>
                                        <td>{{ $contact->nin }}</td>
                                    </tr>
                                    @endif
                                    @if ($contact->birthdate)
                                    <tr>
                                        <td class="text-right"><label class="control-label">{{ trans('manager.contacts.label.birthdate') }}</label></td>
                                        <td>{{ $contact->birthdate->formatLocalized('%d %B %Y') }}</td>
                                    </tr>
                                    @endif
                                    @if ($contact->mobile)
                                    <tr>
                                        <td class="text-right"><label class="control-label">{{ trans('manager.contacts.label.mobile') }}</label></td>
                                        <td>{{ (trim($contact->mobile) != '') ? $contact->mobile : '' }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-right"><label class="control-label">{{ trans('manager.contacts.label.member_since') }}</label></td>
                                        <td>{{ $contact->created_at->diffForHumans() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    {!! $contact->quality == 100 ? ProgressBar::success($contact->quality)->animated()->striped()->visible() : ProgressBar::normal($contact->quality)->animated()->striped()->visible() !!}

                    @if ($contact->user)
                        {!! Button::success($contact->user->username)->withIcon(Icon::ok_circle()) !!}
                    @else
                        {!! Button::warning()->withIcon(Icon::remove_circle()) !!}
                    @endif

                    <span class="pull-right">
                        {!! Button::warning()->withIcon(Icon::edit())->asLinkTo( route('user.business.contact.edit', [$business, $contact]) ) !!}
                    </span>
                </div>
            </div>

            @if($contact->hasAppointment())
            @include('user.contacts._appointment')
            @else
            {!! Button::large()->success(trans('user.appointments.btn.book_in_biz', ['biz' => $business->name]))->asLinkTo(route('user.booking.book', $business))->withIcon(Icon::calendar())->block() !!}
            @endif

        </div>
    </div>
    {!! Form::close() !!}
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
            var row = $('#'+code);

            $(this).parent().hide();

            $.ajax({
                url: form.attr('action'),
                method: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                data: { business: business, appointment: appointment, action: action, widget:'panel' }
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