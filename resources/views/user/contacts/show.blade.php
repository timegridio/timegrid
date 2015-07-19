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
                            <h3 class="panel-title">{{ $contact->fullname }} ({{ trans('app.gender.'.$contact->gender) }}{{ $contact->age > 0 ? ' / ' . $contact->age : '' }})</h3>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="http://lorempixel.com/g/100/100/people" class="img-circle"> </div>
                                
                                <div class=" col-md-9 col-lg-9 ">
                                    <table class="table table-user-information">
                                        <tbody>
                                        @if ($contact->email)
                                        <tr>
                                                <td>{{ trans('manager.contacts.label.email') }}</td>
                                                <td>{{ $contact->email }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                                <td>{{ trans('manager.contacts.label.nin') }}</td>
                                                <td>{{ $contact->nin }}</td>
                                        </tr>
                                        @if ($contact->birthdate)
                                        <tr>
                                                <td>{{ trans('manager.contacts.label.birthdate') }}</td>
                                                <td>{{ $contact->birthdate->toDateString() }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                                <td>{{ trans('manager.contacts.label.member_since') }}</td>
                                                <td>{{ $contact->business($business)->pivot->created_at->diffForHumans() }}</td>
                                        </tr>
                                        @if ($contact->mobile)
                                        <tr>
                                                <td>{{ trans('manager.contacts.label.mobile') }}</td>
                                                <td>{{ (trim($contact->mobile) != '') ? phone_format($contact->mobile, $contact->mobile_country) : '' }}</td>
                                        </tr>
                                        @endif
                                         
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
                        @include('user.contacts._appointment', ['appointments' => $contact->appointments()->orderBy('start_at')->ofBusiness($business)->Active()->get()] )
                @endif

                </div>
            </div>
</div>
@endsection
