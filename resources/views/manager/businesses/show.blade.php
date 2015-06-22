@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('app.home.biz.title') }}</div>

				<div class="panel-body">
					@include('flash::message')

					@if($errors->has())
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
							</ul>
						</div>
					@endif

					<table class="table table-stripped">
						<tr>
							<td>{!! Button::primary($business->slug)->asLinkTo(action('BusinessesController@edit', $business)) !!}</td>
							<td>{{ $business->name }}</td>
							<td>{{ $business->description }}</td>
						</tr>
					</table>

				</div>

				<div class="panel-footer">
					{!! DropdownButton::normal(trans('app.home.btn.actions'))->withContents([
								['url' => action('BusinessesController@index'),  'label' => trans('app.home.btn.manage_business')],
								['url' => action('BusinessesController@create'), 'label' => trans('app.home.btn.manage_create')],
							  ]) !!}
				</div>

			</div>
		</div>
	</div>
</div>
@endsection