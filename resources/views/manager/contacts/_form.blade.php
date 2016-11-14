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

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.firstname.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::text('firstname', null, [
        'id' => 'firstname',
        'required',
        'class' => 'form-control',
        'placeholder'=> old('firstname'),
        'oninvalid' => 'this.setCustomValidity( "'.trans('manager.contacts.form.firstname.validation').'" )',
        'oninput' => 'this.setCustomValidity("")' ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.lastname.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::text('lastname', null, [
        'required',
        'class' => 'form-control',
        'placeholder'=> old('lastname'),
        'oninvalid' => 'this.setCustomValidity( "'.trans('manager.contacts.form.lastname.validation').'" )',
        'oninput' => 'this.setCustomValidity("")' ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.nin.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::text('nin', null, [
        'class' => 'form-control',
        'placeholder'=> old('nin') ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.email.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::email('email', null, [
        'class' => 'form-control',
        'placeholder'=> old('email') ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.gender.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::select('gender', [
        'M' => trans('manager.contacts.form.gender.male.label'),
        'F' => trans('manager.contacts.form.gender.female.label')
        ],
        null,
        ['id' => 'gender', 'class' => 'form-control'] ) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.birthdate.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::text('birthdate', isset($contact) ? old('birthdate', $contact->birthdate ? $contact->birthdate->format(trans('app.dateformat.carbon')) : null) : null, [
        'class' => 'form-control',
        'id' => 'birthdate',
        'placeholder'=> old('birthdate'),
        'title' => trans('manager.contacts.form.birthdate.label') ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.postal_address.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::text('postal_address', null, [
        'class' => 'form-control',
        'placeholder'=> old('postal_address'),
        'oninvalid' => 'this.setCustomValidity( "'.trans('manager.contacts.form.postal_address.validation').'" )',
        'oninput' => 'this.setCustomValidity("")' ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.mobile.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::text('mobile-input', isset($contact) ? old('mobile', $contact->mobile ?: null) : null, [
        'id' => 'mobile-input',
        'class' => 'form-control',
        'placeholder'=> old('mobile') ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.notes.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::textarea('notes', isset($notes) ? $notes : null, [
        'class' => 'form-control',
        'rows' => '4',
        'placeholder'=> old('notes') ]) !!}
        <div class="help-block with-errors"></div>
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
<script src="{{ asset('js/gender/gender.min.js') }}"></script>
<script src="{{ asset('js/lib/utils.js') }}"></script>
<script src="{{ asset('js/intlTelInput/intlTelInput.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function(){

    $('input#firstname').focusout(function(){
        $(this).genderApi({key: '{{ env('GENDERAPI_KEY') }}'}).on('gender-found', function(e, result) {
            if (result.accuracy >= 55) {
                if (result.gender == 'female') {  $('#gender').selectpicker('val', 'F'); };
                console.log('Gender:' + result.gender +
                            ' Accuracy:' + result.accuracy +
                            ' Duration:' + result.duration);
            }
        });
    });

//    $("#birthdate").datetimepicker( {
//        viewMode: 'years',
//        locale: '{{ Session::get('language') }}',
//        format: '{!! trans('app.dateformat.datetimepicker') !!}' }
//        );

//    Select2 Icons disabled for now

//    $('.select2').select2({
//        theme: 'bootstrap'
//    });
//    $('option[value="M"]').data("icon", "ion-male");
//    $('option[value="F"]').data("icon", "ion-female");

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