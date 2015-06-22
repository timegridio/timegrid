@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('manager.businesses.edit.title') }}</div>

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

					{!! Form::model($business, ['method' => 'put', 'route' => ['manager.businesses.update', $business->id]]) !!}
			
					@include('manager.businesses._form')

					<div class="form-group">
						{!! Button::primary(trans('manager.businesses.btn.update'))->submit() !!}
					</div>

					{!! Form::close() !!}
				</div>

				<div class="panel-footer">

				</div>

			</div>
		</div>
	</div>
</div>

@endsection


