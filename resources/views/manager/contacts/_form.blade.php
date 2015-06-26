@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@endsection

	<div class="form-group">
		{!! Form::label( trans('manager.contacts.form.nin.label') ) !!}
		{!! Form::text('nin', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=> trans('manager.contacts.form.nin.placeholder') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('manager.contacts.form.gender.label') ) !!}
		{!! Form::radio('gender','M', true , ['id'=>'male']   ) !!} {!! Form::label( 'male',   trans('manager.contacts.form.gender.male.label') ) !!}
		{!! Form::radio('gender','F', false, ['id'=>'female'] ) !!} {!! Form::label( 'female', trans('manager.contacts.form.gender.female.label') ) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('manager.contacts.form.firstname.label') ) !!}
		{!! Form::text('firstname', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=> trans('manager.contacts.form.firstname.placeholder') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('manager.contacts.form.lastname.label') ) !!}
		{!! Form::text('lastname', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=> trans('manager.contacts.form.lastname.placeholder') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('manager.contacts.form.mobile.label') ) !!}
		{!! Form::select('mobile_country', ['ES'=>'ES','AR'=>'AR'] ) !!}
		{!! Form::text('mobile', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=> trans('manager.contacts.form.mobile.placeholder') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('manager.contacts.form.birthdate.label') ) !!}
		{!! Form::text('birthdate', null, 
			array('required', 
				  'class'=>'form-control',
				  'id'=>'birthdate', 
				  'placeholder'=> trans('manager.contacts.form.birthdate.placeholder') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('manager.contacts.form.notes.label') ) !!}
		{!! Form::textarea('notes', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=> trans('manager.contacts.form.notes.placeholder') )) !!}
	</div>


@section('scripts')
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script>
	$(function() {
	  $( "#birthdate" ).datepicker( { dateFormat: 'yy-mm-dd'} );
	});
	</script>
@endsection