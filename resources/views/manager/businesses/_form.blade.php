@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/intlTelInput/intlTelInput.css') }}">
<style type="text/css">
  .iti-flag {background-image: url("/img/intlTelInput/flags.png");}
  .intl-tel-input {width: 100%;}
</style>
@endsection

{{--
  [META] Translation keys for potsky/laravel-localization-helpers -dev
  trans('app.business.category.doctor')
  trans('app.business.category.garage')
  trans('app.business.category.photography')
--}}

@if(isset($country))
  {{ $country }}
@endif

<div class="row">
    <div class="form-group col-sm-7">
        {!! Form::label( trans('manager.businesses.form.name.label') ) !!}
        {!! Form::text('name', null,
            array('required',
                  'id'=>'name',
                  'class'=>'form-control',
                  'placeholder'=> trans('manager.businesses.form.name.placeholder'),
                  'oninvalid' => 'this.setCustomValidity( "'.trans('manager.businesses.form.name.validation').'" )',
                  'oninput' => 'this.setCustomValidity("")' )) !!}
        <div class="help-block with-errors"></div>
    </div>
    <div class="form-group col-sm-5">
        {!! Form::label( trans('manager.businesses.form.slug.label') ) !!}
        {!! Form::text('slug', null,
            array('required',
                  'readonly'=>'true',
                  'id'=>'slug',
                  'class'=>'form-control',
                  'placeholder'=> trans('manager.businesses.form.slug.placeholder'),
                      'oninvalid' => 'this.setCustomValidity( "'.trans('manager.businesses.form.slug.validation').'" )',
                      'oninput' => 'this.setCustomValidity("")' )) !!}
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
        {!! Form::select('category', $categories, empty($business) ? null : $business->category_id, ['name' => 'category', 'class' => 'selectpicker', 'required']) !!}
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
        {!! Form::label( trans('manager.businesses.form.phone.label') ) !!}<br>
        {!! Form::text('phone-input', empty($business) ? null : $business->phone,
            array('id'=>'phone-input',
                  'class'=>'form-control',
                  'placeholder'=> trans('manager.businesses.form.phone.placeholder') )) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label( trans('manager.businesses.form.social_facebook.label') ) !!}
        {!! Form::text('social_facebook', null,
            array('class'=>'form-control',
                  'placeholder'=> trans('manager.businesses.form.social_facebook.placeholder') )) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>
{!! Form::hidden('phone', '') !!}
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
<script src="{{ asset('js/lib/utils.js') }}"></script>
<script src="{{ asset('js/intlTelInput/intlTelInput.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

    $('#slug').slugify('#name'); // Slug as you type
    $('selectpicker').addClass('dropupAuto');
    $('selectpicker').selectpicker({ size: 1 });
    $("#phone-input").intlTelInput({
      preferredCountries:["ar", "es", "us"],
      defaultCountry: "auto",
      geoIpLookup: function(callback) {
        $.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
          var countryCode = (resp && resp.country) ? resp.country : "";
          callback(countryCode);
        });
      }
  });

  $("form").submit(function() {
    $("input[name=phone]").val($("#phone-input").intlTelInput("getNumber"));
  });

});
</script>
@endsection