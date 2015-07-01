@extends('app')

@section('content')
<div class="container">
	<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('manager.contacts.create.title') }}</div>

				<div class="panel-body">
					@include('flash::message')

					@include('_errors')

					{!! Form::model($contact, ['method' => 'put', 'route' => ['manager.business.contact.update', $business->id, $contact->id ]]) !!}
						@include('manager.contacts._form', ['submitLabel' => trans('manager.contacts.btn.update')])
					{!! Form::close() !!}
				</div>

				<div class="panel-footer">

				</div>
			</div>
	</div>
</div>
@endsection
