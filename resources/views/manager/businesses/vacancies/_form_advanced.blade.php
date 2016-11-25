@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/datetime.css') }}">
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
<link rel="stylesheet" href="{{ asset('css/iCheck/icheck.min.css') }}">
<style>
#vacancies{
    font-size: 1em;
    font-family: Monospace;
    border: 0;
    color: #555;
    line-height: 2em;
    width: 100%;
}
</style>
@endsection

<div class="container-fluid">

    @if(count($humanresourcesList))
    <div class="row">
        {!! Form::label( trans('manager.humanresource.index.title') ) !!}<br>
        {!! Form::select('staff', $humanresourcesList, null, ['id' => 'staff', 'class' => 'form-control select2']) !!}
    </div>
    @endif
    <div class="row">
        {!! Form::label( trans('manager.services.index.title') ) !!}<br>
        {!! Form::select('services', $servicesList, null, ['multiple', 'id' => 'services', 'class' => 'form-control select2']) !!}
    </div>
    <div class="row">
        {!! Form::label( trans_choice('datetime.duration.days', 2) ) !!}<br>
        {!! Form::select('weekdays', $weekdaysList, ['mon', 'tue', 'wed', 'thu', 'fri'], ['multiple', 'id' => 'weekdays', 'class' => 'form-control select2']) !!}
    </div>
    <div class="row">
        {!! Form::label( trans('appointments.text.from') ) !!}<br>
        <div class="input-group bootstrap-timepicker timepicker">
            {!! Form::input('', null, $startAt, ['id' => 'start_at', 'class' => 'form-control input-small', 'type' => 'text', 'data-template' => 'dropdown', 'data-minute-step' => '10']) !!}
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
        </div>
    </div>
    <div class="row">
        {!! Form::label( trans('appointments.text.to') ) !!}<br>
        <div class="input-group bootstrap-timepicker timepicker">
            {!! Form::input('', null, $finishAt, ['id' => 'finish_at', 'class' => 'form-control input-small', 'type' => 'text', 'data-template' => 'dropdown', 'data-minute-step' => '10']) !!}
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
        </div>
    </div>
    <div class="row">
        {!! Form::label( trans('&nbsp;') ) !!}<br>
        {!! Button::withIcon(Icon::plus())->withAttributes(['id' => 'add'])->block() !!}
    </div>
    <div class="row">
        {!! Form::label( trans('&nbsp;') ) !!}<br>
        {!! Button::danger()->withIcon(Icon::trash())->withAttributes(['id' => 'reset'])->block() !!}
    </div>

</div>

<br>
<textarea id="vacancies" name="vacancies" rows="8">
{{ $template }}
</textarea>
<br><br>

<input type="checkbox" name="unpublish" id="unpublish" value="true" />
<label for="unpublish">&nbsp;{{ trans('manager.businesses.check.unpublish_vacancies') }}</label>
<br><br>

<input type="checkbox" name="remember" id="remember" value="true" />
<label for="remember">&nbsp;{{ trans('manager.businesses.check.remember_vacancies') }}</label>
<br><br>

@if (!$business->services->isEmpty())
<div class="row">
    <div class="form-group col-sm-12">
        {!! Button::success(trans('manager.businesses.btn.update'))->block()->large()->submit() !!}
    </div>
</div>
@endif

@push('footer_scripts')
<script src="{{ asset('js/datetime.js') }}"></script>
<script src="{{ asset('js/forms.js') }}"></script>
<script src="{{ asset('js/iCheck/icheck.min.js') }}"></script>
<script>
$(document).ready(function(){

    var statements = [];

    $('#reset').click(function(){
        statements = [];
        $('#vacancies').val('');
    });

    $('#add').click(function(){

        var staff = $('#staff').find(":selected").val();
        if(staff == '')
        {
            // If we dont have Staff members, lets default to simple capacity
            staff = '1';
        }

        var services = [];
        $('#services :selected').each(function(i, selected){
            services[i] = $(selected).val() + ':' + staff;
        });

        if(services.length == 0){
            return false;
        }

        var weekdays = [];
        $('#weekdays :selected').each(function(i, selected){
            weekdays[i] = $(selected).val();
        });

        if(weekdays.length == 0){
            return false;
        }

        var start_at = $('#start_at').val();
        var finish_at = $('#finish_at').val();

        if(start_at.length == 0 || finish_at == 0){
            return false;
        }

        var timeLine = start_at + ' - ' + finish_at;

        var serviceLine = services.join(',');

        var daysLine = weekdays.join(',');

        // Lets build-up the Vacancies statement code for the user
        statements.push(serviceLine + "\n " + daysLine + "\n  " + timeLine + "\n");

        $('#vacancies').val(statements.join("\n"));

        resetControls();

        // ToDo: Flash some success message to the user

        // Do not submit the form
        return false;
    });

    function resetControls()
    {
        $('#services').select2('deselectAll');
        $('#weekdays').select2('deselectAll');
    }

    $('.select2').select2({
        theme: "bootstrap"
    });

    $('#start_at').timepicker();
    $('#finish_at').timepicker();

    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

});
</script>
@endpush