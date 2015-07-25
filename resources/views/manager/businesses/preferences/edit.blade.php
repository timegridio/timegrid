@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('manager.businesses.preferences.title') }}</div>

                <div class="panel-body">
                @include('_errors')

                {!! Form::open(['route' => ['manager.business.preferences', $business->id], 'id' => 'preferences', 'data-toggle' => 'validator']) !!}
                @include('manager.businesses.preferences._form')
                {!! Form::close() !!}

                </div>

                <div class="panel-footer">
                    {!! Button::withIcon(Icon::off())->small()->danger(trans('manager.businesses.btn.deactivate'))->withAttributes(['id' => 'btnDelete', 'data-method' => 'DELETE', 'data-confirm' => trans('manager.business.alert.deactivate_confirm')])->asLinkTo( route('manager.business.destroy', $business) ) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
@parent
<script type="text/javascript">
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

})();
</script>
@endsection