@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-heading">
					@if(\Auth::user()->isOwner($business))
						{!! Icon::star() !!} {!! link_to(route('manager.businesses.show', $business->id), $business->name) !!}
					@else
						{{ $business->name }}
					@endif
				</div>

				<div class="panel-body">

				</div>

				<div class="panel-footer">

				</div>

			</div>
		</div>
	</div>
</div>
@endsection
