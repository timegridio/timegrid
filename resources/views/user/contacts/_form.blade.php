@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
<link rel="stylesheet" href="{{ asset('css/datetime.css') }}">
<link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/intlTelInput/intlTelInput.css') }}">
<style type="text/css">
    .iti-flag { background-image: url("/img/intlTelInput/flags.png"); }
    .intl-tel-input { width: 100%; }
</style>
@endsection

{!! Form::hidden('mobile', '') !!}

<div class="row">
    <div class="form-group col-xs-6">
        {!! Form::text('firstname', $user->name, [
            'required',
            'class'=>'form-control',
            'placeholder'=> trans('manager.contacts.form.firstname.label'),
            'oninvalid' => 'this.setCustomValidity( "'.trans('manager.contacts.form.firstname.validation').'" )',
            'oninput' => 'this.setCustomValidity("")'
            ]) !!}
    </div>
    <div class="form-group col-xs-6">
        {!! Form::text('lastname', null, [
            'required',
            'class'=>'form-control',
            'placeholder'=> trans('manager.contacts.form.lastname.label'),
            'oninvalid' => 'this.setCustomValidity( "'.trans('manager.contacts.form.lastname.validation').'" )',
            'oninput' => 'this.setCustomValidity("")'
            ]) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-xs-6">
        {!! Form::select('gender', ['M' => trans('manager.contacts.form.gender.male.label'), 'F' => trans('manager.contacts.form.gender.female.label')], 'M', ['class'=>'selectpicker'] ) !!}
    </div>
    <div class="form-group col-xs-3">
        {!! Form::text('birthdate', $contact ? old('birthdate', $contact->birthdate ? $contact->birthdate->format(trans('app.dateformat.carbon')) : null) : null, [
            'class'=>'form-control',
            'id'=>'birthdate',
            'placeholder'=> trans('manager.contacts.form.birthdate.label'),
            'title'=> trans('manager.contacts.form.birthdate.label')
            ]) !!}
    </div>
    <div class="form-group col-xs-3">
        {!! Form::text('nin', null, [
            'class'=>'form-control',
            'placeholder'=> trans('manager.contacts.form.nin.label')
            ]) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-xs-6">
        {!! Form::email('email', null, [
            'class'=>'form-control',
            'placeholder'=> trans('manager.contacts.form.email.label')
            ]) !!}
    </div>
    <div class="form-group col-xs-6">
        {!! Form::text('mobile-input', isset($contact) ? old('mobile', $contact->mobile) : null, [
            'id' => 'mobile-input',
            'class'=>'form-control',
            'placeholder'=> trans('manager.contacts.form.mobile.label')
            ]) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-xs-12">
        {!! Button::primary($submitLabel)->block()->submit() !!}
    </div>
</div>


@push('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>
<script src="{{ asset('js/datetime.js') }}"></script>
<script src="{{ asset('js/lib/utils.js') }}"></script>
<script src="{{ asset('js/intlTelInput/intlTelInput.min.js') }}"></script>

<script>
$(document).ready(function(){

    $("#birthdate").datetimepicker( {
        viewMode: 'years',
        locale: '{{Session::get('language')}}',
        format: '{!! trans('app.dateformat.datetimepicker') !!}' }
        );

    $('option[value="M"]').data("icon", "ion-male");
    $('option[value="F"]').data("icon", "ion-female");
    $('selectpicker').addClass('dropupAuto');
    $('selectpicker').selectpicker();

    $("#mobile-input").intlTelInput({
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
        $("input[name=mobile]").val($("#mobile-input").intlTelInput("getNumber"));
    });

});
</script>
@endpush