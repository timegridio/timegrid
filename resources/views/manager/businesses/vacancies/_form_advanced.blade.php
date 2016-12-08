@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
<link rel="stylesheet" href="{{ asset('css/datetime.css') }}">
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

<div class="row">
    <div class="col-md-6">
        <div id="dates"
               type="text"
               class="datepicker-here"
               data-multiple-dates="15"
               data-multiple-dates-separator=", "
               data-show-other-months="true"
               data-date-format="yyyy-m-d"
               data-today-button="false"
               data-clear-button="false"
               data-position='top left'></div>
        <br/>
    </div>
    <div class="col-md-6">

    @if(count($humanresourcesList))
        {!! Form::label( trans('manager.humanresource.index.title') ) !!}<br>
        {!! Form::select('staff', $humanresourcesList, null, ['id' => 'staff', 'class' => 'form-control select2']) !!}
    @endif

    {!! Form::label( trans('manager.services.index.title') ) !!}<br>
    {!! Form::select('services', $servicesList, null, ['multiple', 'id' => 'services', 'class' => 'form-control select2']) !!}

    {!! Form::label( trans('appointments.text.from') ) !!}<br>
    <div class="input-group bootstrap-timepicker timepicker">
        {!! Form::input('', null, $startAt, ['id' => 'start_at', 'class' => 'form-control input-small', 'type' => 'text', 'data-template' => 'dropdown', 'data-minute-step' => '10']) !!}
        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
    </div>

    {!! Form::label( trans('appointments.text.to') ) !!}<br>
    <div class="input-group bootstrap-timepicker timepicker">
        {!! Form::input('', null, $finishAt, ['id' => 'finish_at', 'class' => 'form-control input-small', 'type' => 'text', 'data-template' => 'dropdown', 'data-minute-step' => '10']) !!}
        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
    </div>

    </div>
</div>

    {!! Form::label( trans('&nbsp;') ) !!}<br>
    {!! Button::withIcon(Icon::plus())->withAttributes(['id' => 'add'])->block() !!}
    {!! Form::label( trans('&nbsp;') ) !!}<br>
    {!! Button::danger()->withIcon(Icon::trash())->withAttributes(['id' => 'reset'])->block() !!}

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
    {!! Button::success(trans('manager.businesses.btn.update'))->block()->large()->submit() !!}
@endif

@push('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>
<script src="{{ asset('js/datetime.js') }}"></script>
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

        var start_at = $('#start_at').val();
        var finish_at = $('#finish_at').val();

        if(start_at.length == 0 || finish_at == 0){
            return false;
        }

        var timeLine = start_at + ' - ' + finish_at;

        var serviceLine = services.join(',');

        var daysLine = $('#dates').val();

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
    }

    $('#start_at').timepicker();
    $('#finish_at').timepicker();

    $('.select2').select2({
        theme: "bootstrap"
    });

    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

    $('#dates').datepicker({
        language: timegrid.lang,
        clearButton: false,
        todayButton: false,
    });

});
</script>
@endpush