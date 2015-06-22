	<div class="form-group">
		{!! Form::label( trans('manager.businesses.form.name.label') ) !!}
		{!! Form::text('name', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=> trans('manager.businesses.form.name.placeholder') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('manager.businesses.form.slug.label') ) !!}
		{!! Form::text('slug', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=> trans('manager.businesses.form.slug.placeholder') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('manager.businesses.form.description.label') ) !!}
		{!! Form::textarea('description', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=> trans('manager.businesses.form.description.placeholder') )) !!}
	</div>
