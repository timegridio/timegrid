@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
<link rel="stylesheet" href="{{ asset('css/intlTelInput/intlTelInput.css') }}">
<style type="text/css">
  .iti-flag {background-image: url("/img/intlTelInput/flags.png");}
  .intl-tel-input {width: 100%;}

.bizurl:hover {
    color: #444;
}
.bizurl {
    font-family: monospace;
    color: #666;
}
</style>
@endsection

{{--
  [META] Translation keys for potsky/laravel-localization-helpers -dev
  trans('app.business.category.doctor')
  trans('app.business.category.garage')
  trans('app.business.category.photography')
--}}

<div class="form-group">
    {!! Form::label( trans('manager.businesses.form.name.label'), null, ['class'=>'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
        {!! Form::text('name', null, [
            'required',
            'id' => 'name',
            'class' => 'form-control',
            'placeholder'=> trans('manager.businesses.form.name.placeholder'),
            'oninvalid' => 'this.setCustomValidity( "'.trans('manager.businesses.form.name.validation').'" )',
            'oninput' => 'this.setCustomValidity("")'
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.businesses.form.link.label'), null, ['class'=>'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
        <span class="bizurl">
            <span>{{ url('/') }}/</span><span id="slug"></span>
        </span>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.businesses.form.description.label'), null, ['class' => 'control-label col-sm-3']  ) !!}
    <div class="col-sm-9">
        {!! Form::textarea('description', null, [
            'required',
            'class' => 'form-control',
            'rows' => '6',
            'data-minlength' => '10',
            'placeholder'=> trans('manager.businesses.form.description.placeholder')
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.businesses.form.timezone.label'), null, ['class' => 'control-label col-sm-3'] ) !!}<br>
    <div class="col-sm-9">
        {!! Timezone::selectForm($timezone, trans('app.label.select_timezone'), ['name' => 'timezone', 'class' => 'form-control select2 col-sm-2', 'required'], ['customValue' => 'true']) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.businesses.form.category.label'), null, ['class' => 'control-label col-sm-3'] ) !!}<br>
    <div class="col-sm-9">
        {!! Form::select('category', $categories, empty($business) ? null : $business->category_id, ['name' => 'category', 'class' => 'form-control select2', 'required']) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.businesses.form.postal_address.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
        {!! Form::text('postal_address', null, [
            'id' => 'name',
            'class' => 'form-control',
            'pattern' => '([^,]+)(\,([^,]+))?(\,([^,]+))?(\,([^,]+))?',
            'placeholder'=> trans('manager.businesses.form.postal_address.placeholder')
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.businesses.form.phone.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
        {!! Form::text('phone-input', empty($business) ? null : $business->phone, [
            'id' => 'phone-input',
            'class' => 'form-control',
            'placeholder'=> trans('manager.businesses.form.phone.placeholder')
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.businesses.form.social_facebook.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
        {!! Form::text('social_facebook', null, [
            'class' => 'form-control',
            'placeholder'=> trans('manager.businesses.form.social_facebook.placeholder')
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

{!! Form::hidden('phone', '') !!}
{!! Form::hidden('strategy', 'timeslot') !!}

<div class="form-group">
    <div class="col-md-12">
        {!! Button::primary($submitLabel)->large()->block()->submit() !!}
    </div>
</div>

@push('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>
<script src="{{ asset('js/lib/utils.js') }}"></script>
<script src="{{ asset('js/intlTelInput/intlTelInput.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

    $('#slug').slugify('#name'); // Slug as you type

    $('.select2').select2({ theme: 'boostrap' });

    $("#phone-input").intlTelInput({
        preferredCountries:["us", "gb", "es", "fr", "it", "ar", "br"],
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
@endpush