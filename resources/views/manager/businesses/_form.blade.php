	<div class="form-group">
		{!! Form::label( trans('manager.businesses.form.name.label') ) !!}
		{!! Form::text('name', null, 
			array('required', 
				  'id'=>'name', 
				  'class'=>'form-control', 
				  'placeholder'=> trans('manager.businesses.form.name.placeholder') )) !!}
	</div>

	<div class="form-group">
		{!! Form::label( trans('manager.businesses.form.slug.label') ) !!}
		{!! Form::text('slug', null, 
			array('required', 
				  'readonly'=>'true', 
				  'id'=>'slug', 
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

@section('scripts')
<script src="{{ asset('js/speakingurl.min.js') }}"></script>
<script src="{{ asset('js/slugify.min.js') }}"></script>

<script>
jQuery(function($) {
  $('#slug').slugify('#name'); // Type as you slug
});
</script>
@endsection

