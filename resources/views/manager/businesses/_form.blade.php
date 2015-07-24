@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
@endsection

<div class="row">
    <div class="form-group col-sm-7">
        {!! Form::label( trans('manager.businesses.form.name.label') ) !!}
        {!! Form::text('name', null,
            array('required',
                  'id'=>'name',
                  'class'=>'form-control',
                  'placeholder'=> trans('manager.businesses.form.name.placeholder') )) !!}
        <div class="help-block with-errors"></div>
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
                  'rows'=>'3',
                  'data-minlength'=>'10',
                  'placeholder'=> trans('manager.businesses.form.description.placeholder') )) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label( trans('manager.businesses.form.timezone.label') ) !!}<br>
        {!! Timezone::selectForm($timezone, trans('app.label.select_timezone'), ['name' => 'timezone', 'class' => 'selectpicker', 'required'], ['customValue' => 'true']) !!}
        <div class="help-block with-errors"></div>
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label( trans('manager.businesses.form.category.label') ) !!}<br>
        {!! Form::select('category', $categories, null, ['name' => 'category', 'class' => 'selectpicker', 'required']) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>
<div class="row">    
    <div class="form-group col-sm-6">
        {!! Form::label( trans('manager.businesses.form.postal_address.label') ) !!}
        {!! Form::text('postal_address', null,
            array('id'=>'name',
                  'class'=>'form-control',
                  'pattern' => '([^,]+)(\,([^,]+))?(\,([^,]+))?(\,([^,]+))?',
                  'placeholder'=> trans('manager.businesses.form.postal_address.placeholder') )) !!}
        <div class="help-block with-errors"></div>
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label( trans('manager.businesses.form.phone.label') ) !!}
        {!! Form::text('phone', null,
            array('class'=>'form-control',
                  'pattern' => '(\+|00)(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}',
                  'placeholder'=> trans('manager.businesses.form.phone.placeholder') )) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>
{!! Form::hidden('strategy', 'dateslot') !!}
<div class="row">
    <div class="form-group col-md-12">
        {!! Button::primary($submitLabel)->large()->block()->submit() !!}
    </div>
</div>

@section('footer_scripts')
@parent
<script src="{{ asset('js/bootstrap-validator.min.js') }}"></script>
<script src="{{ asset('js/speakingurl.min.js') }}"></script>
<script src="{{ asset('js/slugify.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

    $('#slug').slugify('#name'); // Slug as you type
    $('selectpicker').addClass('dropupAuto');
    $('selectpicker').selectpicker({ size: 1 });

});
</script>
@endsection