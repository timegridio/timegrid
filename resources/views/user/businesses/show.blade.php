@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-heading">
					@if(\Auth::user()->isOwner($business))
						{!! Icon::star() !!} {!! link_to(route('manager.business.show', $business), $business->name) !!}
					@else
						{{ $business->name }}
					@endif
				</div>

				<div class="panel-body">
					{{ $business->description }}
				</div>

				<div class="panel-footer">
					@if (\Auth::user()->suscribedTo($business) !== null)
						{!! Button::normal(trans('user.appointments.btn.book'))->asLinkTo( route('user.booking.book') ) !!}
					@else
						{!! Button::normal(trans('user.business.btn.suscribe'))->asLinkTo( route('user.business.contact.create', $business) ) !!}
					@endif
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
