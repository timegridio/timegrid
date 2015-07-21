@extends('app')

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
<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad" >

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $contact->fullname }}</h3>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 " align="center">
                                    @if($contact->email)
                                        <img alt="{{$contact->fullname}}" src="{{ Gravatar::get($contact->email) }}" class="img-circle">
                                    @endif
                                    <p>&nbsp;</p><small>{{ trans('app.gender.'.$contact->gender) }} {{ $contact->age or '' }}</small>
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
                                                <td>{{ (trim($contact->mobile) != '') ? phone_format($contact->mobile, $contact->mobile_country) : '' }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                                <td class="text-right"><label class="control-label">{{ trans('manager.contacts.label.member_since') }}</label></td>
                                                <td>{{ $contact->business($business)->pivot->created_at->diffForHumans() }}</td>
                                        </tr>                                         
                                        </tbody>
                                    </table>
                                    
                                    
                                </div>
                            </div>
                        </div>
                                 <div class="panel-footer">
                                                {!! $contact->quality == 100 ? ProgressBar::success($contact->quality)->animated()->striped()->visible() : ProgressBar::normal($contact->quality)->animated()->striped()->visible() !!}
                                                
                                                @if ($contact->username)
                                                    {!! Button::success($contact->username)->withIcon(Icon::ok_circle()) !!}
                                                @else
                                                    {!! Button::warning()->withIcon(Icon::remove_circle()) !!}
                                                @endif

                                                <span class="pull-right">
                                                        {!! Button::warning()->withIcon(Icon::edit())->asLinkTo( route('user.business.contact.edit', [$business, $contact]) ) !!}
                                                </span>
                                 </div>
                        
                    </div>

                @if($contact->hasAppointment())
                    @include('user.contacts._appointment', ['appointments' => $contact->appointments()->orderBy('start_at')->ofBusiness($business)->future()->get()] )
                @else
                    {!! Button::large()->success(trans('user.appointments.btn.book_in_biz', ['biz' => $business->name]))->asLinkTo(route('user.booking.book'))->withIcon(Icon::calendar())->block() !!}
                @endif

                </div>
            </div>
</div>
@endsection
