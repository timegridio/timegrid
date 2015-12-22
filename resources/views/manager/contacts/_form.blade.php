@section('css')
<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/intlTelInput/intlTelInput.css') }}">
<style type="text/css">
    .iti-flag { background-image: url("/img/intlTelInput/flags.png"); }
    .intl-tel-input { width: 100%; }
</style>
@endsection

{!! Form::hidden('mobile', '') !!}
<div class="row">
    <div class="form-group col-xs-4">
        {!! Form::text('firstname', null, [
            'id' => 'firstname',
            'required',
            'class'=>'form-control',
            'placeholder'=> trans('manager.contacts.form.firstname.label'),
            'oninvalid' => 'this.setCustomValidity( "'.trans('manager.contacts.form.firstname.validation').'" )',
            'oninput' => 'this.setCustomValidity("")' ]) !!}
    </div>
    <div class="form-group col-xs-8">
        {!! Form::text('lastname', null, [
            'required',
            'class'=>'form-control',
            'placeholder'=> trans('manager.contacts.form.lastname.label'),
            'oninvalid' => 'this.setCustomValidity( "'.trans('manager.contacts.form.lastname.validation').'" )',
            'oninput' => 'this.setCustomValidity("")' ]) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-4">
    {!! Form::text('nin', null, [
        'class'=>'form-control',
        'placeholder'=> trans('manager.contacts.form.nin.label') ]) !!}
    </div>
    <div class="form-group col-xs-8">
        {!! Form::email('email', null, [
            'class'=>'form-control',
            'placeholder'=> trans('manager.contacts.form.email.label') ]) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-4">
        {!! Form::select('gender', [
            'M' => trans('manager.contacts.form.gender.male.label'),
            'F' => trans('manager.contacts.form.gender.female.label')
            ],
            null,
            ['id' => 'gender', 'class'=>'selectpicker'] ) !!}
    </div>
    <div class="form-group col-xs-8">
        {!! Form::text('birthdate', isset($contact) ? old('birthdate', $contact->birthdate ? $contact->birthdate->format(trans('app.dateformat.carbon')) : null) : null, [
            'class'=>'form-control',
            'id'=>'birthdate',
            'placeholder'=> trans('manager.contacts.form.birthdate.label'),
            'title'=> trans('manager.contacts.form.birthdate.label') ]) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12">
        {!! Form::text('mobile-input', isset($contact) ? old('mobile', $contact->mobile ?: null) : null, [
            'id' => 'mobile-input',
            'class'=>'form-control',
            'placeholder'=> trans('manager.contacts.form.mobile.label') ]) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12">
        {!! Form::textarea('notes', isset($notes) ? $notes : null, [
            'class'=>'form-control',
            'rows'=>'4',
            'placeholder'=> trans('manager.contacts.form.notes.label') ]) !!}
    </div>
</div>
<div class="row">
    <div class="notes form-group col-xs-12">
        {!! Button::primary($submitLabel)->block()->submit() !!}
    </div>
</div>

@section('footer_scripts')
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/gender/gender.min.js') }}"></script>
<script src="{{ asset('js/lib/utils.js') }}"></script>
<script src="{{ asset('js/intlTelInput/intlTelInput.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function(){

    $('input#firstname').focusout(function(){
        $(this).genderApi({key: '{{ env('GENDERAPI_KEY') }}'}).on('gender-found', function(e, result) {
            if (result.accuracy >= 55) {
                if (result.gender == 'female') {  $('#gender').selectpicker('val', 'F'); };
                console.log('Gender: ' + result.gender + ' ACC:' + result.accuracy + ' Duration:' + result.duration);
            }
        });
    });

    $("#birthdate").datetimepicker( { 
        viewMode: 'years',
        locale: '{{Session::get('language')}}',
        format: '{!! trans('app.dateformat.datetimepicker') !!}' } 
        );

    $('selectpicker').addClass('dropupAuto');
    $('selectpicker').selectpicker();
    $('option[value="M"]').data("icon", "ion-male");
    $('option[value="F"]').data("icon", "ion-female");

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
@endsection