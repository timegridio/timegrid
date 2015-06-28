@extends('app')

@section('content')
<div class="container">
	<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('manager.contacts.create.title') }}</div>

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

					{!! Form::model(new App\Contact, ['route' => ['manager.contacts.store']]) !!}
			
					@include('manager.contacts._form')

					<div class="form-group">
						{!! Button::primary(trans('manager.contacts.btn.store'))->submit() !!}
					</div>

					{!! Form::close() !!}
				</div>

				<div class="panel-footer">
					
				</div>

			</div>
	</div>
</div>

@endsection
