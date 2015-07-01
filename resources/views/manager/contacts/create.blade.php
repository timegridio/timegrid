@extends('app')

@section('content')
<div class="container">
	<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('manager.contacts.create.title') }}</div>

				<div class="panel-body">
					@include('flash::message')

					@include('_errors')

					{!! Form::model(new App\Contact, ['route' => ['manager.business.contact.store', $business]]) !!}
						@include('manager.contacts._form',['submitLabel' => trans('manager.contacts.btn.store')])
					{!! Form::close() !!}
				</div>

				<div class="panel-footer">
					
				</div>
			</div>
	</div>
</div>
@endsection