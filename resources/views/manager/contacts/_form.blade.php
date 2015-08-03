@section('css')
<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endsection

    <div class="row">
        <div class="form-group col-xs-4">
            {!! Form::text('firstname', null, 
                array('id' => 'firstname',
                      'required', 
                      'class'=>'form-control', 
                      'placeholder'=> trans('manager.contacts.form.firstname.label') )) !!}
        </div>
        <div class="form-group col-xs-8">
            {!! Form::text('lastname', null, 
                array('required', 
                      'class'=>'form-control', 
                      'placeholder'=> trans('manager.contacts.form.lastname.label') )) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-4">
            {!! Form::text('nin', null, 
                array('class'=>'form-control', 
                      'placeholder'=> trans('manager.contacts.form.nin.label') )) !!}
        </div>
        <div class="form-group col-xs-8">
            {!! Form::email('email', null, 
                array('class'=>'form-control', 
                      'placeholder'=> trans('manager.contacts.form.email.label') )) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-4">
            {!! Form::select('gender', ['M' => trans('manager.contacts.form.gender.male.label'), 'F' => trans('manager.contacts.form.gender.female.label')], 'M', ['id' => 'gender', 'class'=>'selectpicker'] ) !!}
        </div>
        <div class="form-group col-xs-8">
            {!! Form::text('birthdate', isset($contact) ? old('birthdate', $contact->birthdate ? $contact->birthdate->toDateString() : null) : null, 
                array('class'=>'form-control',
                      'id'=>'birthdate',
                      'placeholder'=> trans('manager.contacts.form.birthdate.label'),
                      'title'=> trans('manager.contacts.form.birthdate.label') )) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-4">
            {!! Form::select('mobile_country', Location::lists(), isset($contact) ? old('mobile_country', $contact->mobile_country ) : Location::get()->countryCode, ['class'=>'selectpicker'] ) !!}
        </div>
        <div class="form-group col-xs-8">
            {!! Form::text('mobile', null, 
                array('class'=>'form-control', 
                      'placeholder'=> trans('manager.contacts.form.mobile.label') )) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-12">
            {!! Form::textarea('notes', isset($contact) ? $contact->business($business)->pivot->notes : null, 
                array('class'=>'form-control',
                      'rows'=>'4',
                      'placeholder'=> trans('manager.contacts.form.notes.label') )) !!}
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

    <script type="text/javascript">
    $(document).ready(function(){ 

    $('input#firstname').focusout(function(){
      $(this).genderApi({key: '{{ env('GENDERAPI_KEY') }}'}).on('gender-found', function(e, result) {
            if (result.accuracy >= 55) {
                if (result.gender == 'female') {  $('#gender').selectpicker('val', 'F'); };
                console.log('Gender found: ' + result.gender + ' Accuracy:' + result.accuracy + ' Duration:' + result.duration);
            }
        });
    });

      $("#birthdate").datetimepicker( { viewMode: 'years', locale: '{{Session::get('language')}}', format: '{!! trans('app.dateformat.datetimepicker') !!}' } );
      $('selectpicker').addClass('dropupAuto');
      $('selectpicker').selectpicker();
      /* $('option[value="M"]').data("icon", "ion-male"); */
      /* $('option[value="F"]').data("icon", "ion-female"); */
    });
    </script>
@endsection