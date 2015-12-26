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
.toppad {
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
                                <img alt="{{$contact->fullname}}"
                                     src="{{ Gravatar::get($contact->email) }}"
                                     class="img-circle">
                            @endif
                            <p>&nbsp;</p>
                            <small>{{ trans('app.gender.'.$contact->gender) }} {{ $contact->age or '' }}</small>
                        </div>
                        
                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-user-information">
                                <tbody>
                                @if ($contact->email)
                                <tr>
                                    <td class="text-right">
                                        <label class="control-label">
                                            {{ trans('manager.contacts.label.email') }}
                                        </label>
                                    </td>
                                    <td>{{ $contact->email }}</td>
                                </tr>
                                @endif
                                @if ($contact->nin)
                                <tr>
                                    <td class="text-right">
                                        <label class="control-label">
                                            {{ trans('manager.contacts.label.nin') }}
                                        </label>
                                    </td>
                                    <td>{{ $contact->nin }}</td>
                                </tr>
                                @endif
                                @if ($contact->birthdate)
                                <tr>
                                    <td class="text-right">
                                        <label class="control-label">
                                            {{ trans('manager.contacts.label.birthdate') }}
                                        </label>
                                    </td>
                                    <td>{{ $contact->birthdate->formatLocalized('%d %B %Y') }}</td>
                                </tr>
                                @endif
                                @if ($contact->mobile)
                                <tr>
                                    <td class="text-right">
                                        <label class="control-label">
                                            {{ trans('manager.contacts.label.mobile') }}
                                        </label>
                                    </td>
                                    <td>{{ (trim($contact->mobile) != '') ? phone_format($contact->mobile, $contact->mobile_country) : '' }}</td>
                                </tr>
                                @endif
                                @if ($contact->postal_address)
                                <tr>
                                    <td class="text-right">
                                        <label class="control-label">
                                            {{ trans('manager.contacts.label.postal_address') }}
                                        </label>
                                    </td>
                                    <td>{{ $contact->postal_address }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-right">
                                        <label class="control-label">
                                            {{ trans('manager.contacts.label.member_since') }}
                                        </label>
                                        </td>
                                    <td>{{ $contact->pivot->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">
                                        <label class="control-label">{{ trans('manager.contacts.label.notes') }}</label>
                                    </td>
                                    <td>{{ $contact->pivot->notes }}</td>
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
                {!! Button::warning()
                    ->withIcon(Icon::edit())
                    ->asLinkTo( route('manager.business.contact.edit', [$business, $contact]) )
                    ->withAttributes([
                        'data-for' => 'edit',
                        'data-toggle' => 'tooltip',
                        'data-original-title' => trans('manager.contacts.btn.edit')])
                    !!}

                {!! Button::danger()
                    ->withIcon(Icon::trash())
                    ->asLinkTo( route('manager.business.contact.destroy', [$business, $contact]) )
                    ->withAttributes([
                        'id' => 'delete-btn',
                        'type' => 'button',
                        'data-for' => 'delete',
                        'data-toggle' => 'tooltip',
                        'data-method' => 'DELETE',
                        'data-original-title' => trans('manager.contacts.btn.delete'),
                        'data-confirm'=> trans('manager.contacts.btn.confirm_delete')])
                    !!}
                </span>
            </div>
                
            </div>

        @if($contact->hasAppointment())
        @include('manager.contacts._appointment', ['appointments' => $contact->appointments()->orderBy('start_at')->ofBusiness($business)->Active()->get()] )
        @endif

        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script>
$(document).ready(function() {
    var panels = $('.user-infos');
    var panelsButton = $('.dropdown-user');
    panels.hide();

    //Click dropdown
    panelsButton.click(function() {
        //get data-for attribute
        var dataFor = $(this).data('for');
        var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function() {
            //Completed slidetoggle
            if(idFor.is(':visible'))
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
            }
            else
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
            }
        })
    });

    $('[data-toggle="tooltip"]').tooltip();
});

(function() {
 
    var laravel = {
        initialize: function() {
            this.methodLinks = $('a[data-method]');
 
            this.registerEvents();
        },
 
        registerEvents: function() {
            this.methodLinks.on('click', this.handleMethod);
        },
 
        handleMethod: function(e) {
            var link = $(this);
            var httpMethod = link.data('method').toUpperCase();
            var form;
 
            // If the data-method attribute is not PUT or DELETE,
            // then we don't know what to do. Just ignore.
            if ( $.inArray(httpMethod, ['PUT', 'DELETE']) === - 1 ) {
                return;
            }
 
            // Allow user to optionally provide data-confirm="Are you sure?"
            if ( link.data('confirm') ) {
                if ( ! laravel.verifyConfirm(link) ) {
                    return false;
                }
            }
 
            form = laravel.createForm(link);
            form.submit();
 
            e.preventDefault();
        },
 
        verifyConfirm: function(link) {
            return confirm(link.data('confirm'));
        },
 
        createForm: function(link) {
            var form =
            $('<form>', {
                'method': 'POST',
                'action': link.attr('href')
            });
 
            var token =
            $('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': '{{{ csrf_token() }}}' // hmmmm...
                });
 
            var hiddenInput =
            $('<input>', {
                'name': '_method',
                'type': 'hidden',
                'value': link.data('method')
            });
 
            return form.append(token, hiddenInput).appendTo('body');
        }
    };
 
    laravel.initialize();

    $("img").error(function(){
        $(this).hide();
    });

})();
</script>
@endsection