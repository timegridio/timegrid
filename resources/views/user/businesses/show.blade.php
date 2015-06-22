@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $business->name }}</div>

				<div class="panel-body">

				</div>

				<div class="panel-footer">
					{!! Button::normal(trans('user.businesses.show.btn.change'))->asLinkTo(action('HomeController@selector')) !!}
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
