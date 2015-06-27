@extends('app')

@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@endsection

@section('content')
<div class="container">
	{!! Form::open(array('route' => 'user/booking/store', 'class' => 'form')) !!}

	<div class="form-group">
		{!! Form::label( trans('user.appointments.form.date.label') ) !!}
		{!! Form::text('date', null, 
			array('required', 
				  'class'=>'form-control',
				  'id'=>'date', 
				  'placeholder'=> trans('user.appointments.form.date.label') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('user.appointments.form.time.label') ) !!}
		{!! Form::text('time', null, 
			array('required', 
				  'class'=>'form-control',
				  'id'=>'time',
				  'placeholder'=> trans('user.appointments.form.time.label') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('user.appointments.form.business.label') ) !!}
		{!! Form::text('business_id', null, 
			array('required', 
				  'class'=>'form-control',
				  'placeholder'=> trans('user.appointments.form.business.label') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('user.appointments.form.contact_id.label') ) !!}
		{!! Form::text('contact_id', 8, 
			array('required', 
				  'class'=>'form-control',
				  'placeholder'=> trans('user.appointments.form.contact_id.label') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('user.appointments.form.duration.label') ) !!}
		{!! Form::text('duration', 45, 
			array('required', 
				  'class'=>'form-control',
				  'placeholder'=> trans('user.appointments.form.duration.label') )) !!}
	</div>


	<div class="form-group">
		{!! Form::label( trans('user.appointments.form.comments.label') ) !!}
		{!! Form::text('comments', 'test', 
			array('required', 
				  'class'=>'form-control',
				  'placeholder'=> trans('user.appointments.form.comments.label') )) !!}
	</div>

	<div class="form-group">
		{!! Button::primary(trans('manager.contacts.btn.store'))->submit() !!}
	</div>

	{!! Form::close() !!}
</div>
@endsection

@section('scripts')
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script>
	$(function() {
	  $( "#date" ).datepicker( { dateFormat: 'yy-mm-dd'} );
	});
	</script>
@endsection