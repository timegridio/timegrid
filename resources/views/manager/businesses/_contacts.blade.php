<div class="panel panel-default">
	<div class="panel-heading">{{ $business->name }}</div>

	<div class="panel-body">

		<table class="table table-stripped">
		@foreach ($business->contacts as $contact)
			<tr>
				<td>{{ $contact->firstname }}</td>
				<td>{{ $contact->lastname }}</td>
			</tr>
		@endforeach
		</table>

	</div>

	<div class="panel-footer">
		{!! Button::primary(trans('manager.businesses.contacts.btn.create'))->asLinkTo( action('ContactsController@create') ) !!}
	</div>

</div>