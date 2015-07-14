@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default">

				<div class="panel-heading">{{ trans('manager.businesses.index.title') }}</div>

				<div class="panel-body">
					@if(\Auth::user()->hasBusiness())
						{!! Alert::info(trans('manager.businesses.index.help')) !!}
	
						<table class="table table-condensed">
						@foreach ($businesses as $business)
							<tr>
								<td>{!! Button::primary($business->slug)->asLinkTo( route('manager.business.show', ['business' => $business]) ) !!}</td>
								<td>{{ $business->name }}</td>
								<td>{{ $business->description }}</td>
							</tr>
						@endforeach
						</table>

						<div class="panel-footer">
							{!! DropdownButton::normal(trans('app.home.btn.actions'))->withContents([
										['url' => route('manager.business.index'),  'label' => trans('manager.businesses.index.btn.manage')],
										['url' => route('manager.business.create'), 'label' => trans('manager.businesses.index.btn.register')],
							]) !!}
						</div>
					@else
						{!! Alert::info(trans('manager.businesses.index.register_business_help')) !!}
						<div class="text-center">{!! Button::success(trans('user.businesses.index.btn.power_create'))->large()->asLinkTo( route('manager.business.create') ) !!}</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@if(!\Auth::user()->hasBusiness())
	@section('footer_scripts')
	@parent
	{!! TidioChat::js() !!}
	@endsection
@endif