<div class="container">
	<div class="row">
		<div class="form-group col-xs-6">
			{!! Form::text('name', null, 
				array('required', 
					  'class'=>'form-control', 
					  'placeholder'=> trans('manager.service.form.name.label') )) !!}
		</div>
	</div>
	<div class="row">
		<div class="form-group col-xs-11">
			{!! Form::textarea('description', null, 
				array('class'=>'form-control', 
					  'placeholder'=> trans('manager.contacts.form.description.label') )) !!}
		</div>
	</div>
	<div class="row">
		<div class="notes form-group col-xs-11">
			{!! Button::primary($submitLabel)->submit() !!}
		</div>
	</div>
</div>