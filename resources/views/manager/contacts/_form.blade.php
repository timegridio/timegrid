@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css">
@endsection

<div class="container">
    <div class="row">
        <div class="nin col-xs-4">
			<div class="form-group">
				{!! Form::text('nin', null, 
					array('required', 
						  'class'=>'form-control', 
						  'placeholder'=> trans('manager.contacts.form.nin.label') )) !!}
			</div>
        </div>
        <div class="email col-xs-7">
			<div class="form-group">
				{!! Form::text('email', null, 
					array('class'=>'form-control', 
						  'placeholder'=> trans('manager.contacts.form.email.label') )) !!}
			</div>
        </div>
    </div>
    <div class="row extra">
        <div class="gender col-xs-5">
			<div class="form-group">
				{!! Form::select('gender', ['M' => trans('manager.contacts.form.gender.male.label'), 'F' => trans('manager.contacts.form.gender.female.label')], 'M', ['class'=>'selectpicker'] ) !!}
{{--				{!! Form::radio('gender','M', true , ['id'=>'male']   ) !!} {!! Form::label( 'male',   trans('manager.contacts.form.gender.male.label') ) !!}      --}}
{{--				{!! Form::radio('gender','F', false, ['id'=>'female'] ) !!} {!! Form::label( 'female', trans('manager.contacts.form.gender.female.label') ) !!}    --}}
			</div>
        </div>
        <div class="birthdate col-xs-6">
			<div class="form-group">
				{!! Form::text('birthdate', null, 
					array('required', 
						  'class'=>'form-control',
						  'id'=>'birthdate', 
						  'placeholder'=> trans('manager.contacts.form.birthdate.label') )) !!}
			</div>
        </div>
    </div>
    <div class="row name">
        <div class="first col-xs-6">
			<div class="form-group">
				{!! Form::text('firstname', null, 
					array('required', 
						  'class'=>'form-control', 
						  'placeholder'=> trans('manager.contacts.form.firstname.label') )) !!}
			</div>
        </div>
        <div class="last col-xs-5">
			<div class="form-group">
				{!! Form::text('lastname', null, 
					array('required', 
						  'class'=>'form-control', 
						  'placeholder'=> trans('manager.contacts.form.lastname.label') )) !!}
			</div>
        </div>
    </div>
    <div class="row contact">
        <div class="mobile_country col-xs-4">
        	<div class="form-group">
				{!! Form::select('mobile_country', ['ES'=>'ES','AR'=>'AR'], 'AR', ['class'=>'selectpicker'] ) !!}
			</div>
        </div>
        <div class="mobile col-xs-7">
			<div class="form-group">
				{!! Form::text('mobile', null, 
					array('class'=>'form-control', 
						  'placeholder'=> trans('manager.contacts.form.mobile.label') )) !!}
			</div>
        </div>
    </div>
    <div class="row notes">
        <div class="notes col-xs-11">
			<div class="form-group">
				{!! Form::textarea('notes', null, 
					array('required', 
						  'class'=>'form-control', 
						  'placeholder'=> trans('manager.contacts.form.notes.label') )) !!}
			</div>
        </div>
    </div>
</div>

@section('scripts')
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js"></script>

	<script>
	$(document).ready(function(){ 
	  $("#birthdate").datepicker( { dateFormat: 'yy-mm-dd'} );
	  $('selectpicker').selectpicker();
	});
	</script>
@endsection