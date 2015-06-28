@section('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css">
@endsection
    <div class="row">
        <div class="form-group col-sm-7">
			{!! Form::label( trans('manager.businesses.form.name.label') ) !!}
			{!! Form::text('name', null, 
				array('required', 
					  'id'=>'name', 
					  'class'=>'form-control', 
					  'placeholder'=> trans('manager.businesses.form.name.placeholder') )) !!}
        </div>
        <div class="form-group col-sm-5">
			{!! Form::label( trans('manager.businesses.form.slug.label') ) !!}
			{!! Form::text('slug', null, 
				array('required', 
					  'readonly'=>'true', 
					  'id'=>'slug', 
					  'class'=>'form-control', 
					  'placeholder'=> trans('manager.businesses.form.slug.placeholder') )) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
			{!! Form::label( trans('manager.businesses.form.description.label') ) !!}
			{!! Form::textarea('description', null, 
				array('required', 
					  'class'=>'form-control', 
					  'placeholder'=> trans('manager.businesses.form.description.placeholder') )) !!}
        </div>
    </div>
    <div class="row">
		<div class="form-group col-sm-6">
			{!! Timezone::selectForm($timezone, trans('app.label.select_timezone'), ['name' => 'timezone', 'class' => 'selectpicker'], ['customValue' => 'true']) !!}
		</div>
		<div class="form-group col-sm-6">
			<span class="alert alert-info">{{ Carbon::now()->timezone($timezone)->toDateTimeString() }}</span>
		</div>
    </div>

@section('scripts')
<script src="{{ asset('js/speakingurl.min.js') }}"></script>
<script src="{{ asset('js/slugify.min.js') }}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js"></script>

<script>
jQuery(function($) {
	$('#slug').slugify('#name'); // Type as you slug
	$('selectpicker').addClass('dropupAuto');
	$('selectpicker').selectpicker({ size: 1 });
});
</script>
@endsection

