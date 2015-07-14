@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $business->name }}</div>

				<div class="panel-body">
					<p>{{ $business->description }}</p>
				</div>

				<div class="panel-footer">
					{!! Button::withIcon(Icon::edit())->primary()->asLinkTo( route('manager.business.edit', $business) ) !!}
					{!! Button::withIcon(Icon::trash())->danger()->withAttributes(['data-method' => 'DELETE', 'data-confirm' => trans('app.general.btn.confirm_deletion')])->asLinkTo( route('manager.business.destroy', $business) ) !!}
					{!! Button::withIcon(Icon::tag())->normal()->asLinkTo( route('manager.business.service.index', $business) ) !!}
					{!! Button::withIcon(Icon::time())->normal()->asLinkTo( route('manager.business.vacancy.create', $business) ) !!}
				</div>
			</div>
			@include('manager.businesses._contacts')
		</div>
	</div>
</div>
@endsection

@section('footer_scripts')
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