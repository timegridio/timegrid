@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $business->name }}</div>

				<div class="panel-body">
					@include('flash::message')
					
					@include('_errors')

					<p>{{ $business->description }}</p>
				</div>

				<div class="panel-footer">
					{!! Button::withIcon(Icon::edit())->primary()->asLinkTo( route('manager.businesses.edit', $business) ) !!}
				</div>
			</div>
			@include('manager.businesses._contacts')
		</div>
	</div>
</div>
@endsection