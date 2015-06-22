	<div class="form-group">
		{!! Form::label('Name') !!}
		{!! Form::text('name', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=>'Your business name')) !!}
	</div>

	<div class="form-group">
		{!! Form::label('Slug') !!}
		{!! Form::text('slug', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=>'Your business slug')) !!}
	</div>

	<div class="form-group">
		{!! Form::label('Description') !!}
		{!! Form::textarea('description', null, 
			array('required', 
				  'class'=>'form-control', 
				  'placeholder'=>'Describe your business')) !!}
	</div>
