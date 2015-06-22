@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $business->name }} ({{ $business->owner()->email }})</div>

				<div class="panel-body">
					
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
