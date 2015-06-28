@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('manager.businesses.create.title') }}</div>

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

					{!! Form::model(new App\Business, ['route' => ['manager.businesses.store']]) !!}
			
					@include('manager.businesses._form')

				    <div class="row">
						<div class="form-group col-sm-2">
							{!! Button::primary(trans('manager.businesses.btn.store'))->submit() !!}
						</div>
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
