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

      @include('flash::message')

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">{{ $contact->fullname }}</h3>
            </div>

            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="http://lorempixel.com/g/100/100/people" class="img-circle"> </div>
                
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                    <tr>
                        <td>{{ trans('manager.contacts.label.username') }}</td>
                        <td>{{ $contact->username }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('manager.contacts.label.email') }}</td>
                        <td>{{ $contact->email }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('manager.contacts.label.nin') }}</td>
                        <td>{{ $contact->nin }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('manager.contacts.label.birthdate') }}</td>
                        <td>{{ $contact->birthdate->toDateString() }} ({{ $contact->age }})</td>
                    </tr>
                    <tr>
                        <td>{{ trans('manager.contacts.label.notes') }}</td>
                        <td>{{ $contact->notes }}</td>
                    </tr>                   
                    <tr>
                      <tr>
                        <td>{{ trans('manager.contacts.label.gender') }}</td>
                        <td>{{ trans('app.gender.'.$contact->gender) }}</td>
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
                        {!! Button::primary()->withIcon(Icon::link()) !!}
                        <span class="pull-right">
                            {!! Button::warning()->withIcon(Icon::edit())->asLinkTo( route('manager.contacts.edit', $contact) ) !!}
                            {!! Button::danger()->withIcon(Icon::trash())->withAttributes(['type' => 'button', 'data-toggle' => 'tooltip', 'data-original-title' => trans('manager.contacts.btn.delete'), 'data-method'=>'DELETE', 'data-confirm'=>'Delete?'])->asLinkTo( route('manager.contacts.destroy', $contact) ) !!}
                        </span>
                 </div>
            
          </div>

        @if($contact->hasAppointment())
            @include('manager.contacts._appointment', ['appointments' => $contact->appointments] )
        @endif

        </div>
      </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    var panels = $('.user-infos');
    var panelsButton = $('.dropdown-user');
    panels.hide();

    //Click dropdown
    panelsButton.click(function() {
        //get data-for attribute
        var dataFor = $(this).attr('data-for');
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

    $('button').click(function(e) {
        e.preventDefault();
        alert("This is a demo.\n :-)");
    });
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
 
      return form.append(token, hiddenInput)
                 .appendTo('body');
    }
  };
 
  laravel.initialize();
 
})();
</script>
@endsection