@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
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
    @if(count($humanresourcesList))
    <div class="col-sm-3">
        {!! Form::label( trans('manager.humanresource.index.title') ) !!}<br>
        {!! Form::select('staff', $humanresourcesList, null, ['id' => 'staff', 'class' => 'selectpicker']) !!}
    </div>
    @endif
    <div class="col-sm-3">
        {!! Form::label( trans('manager.services.index.title') ) !!}<br>
        {!! Form::select('services', $servicesList, null, ['multiple', 'id' => 'services', 'class' => 'selectpicker']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::label( trans_choice('datetime.duration.days', 2) ) !!}<br>
        {!! Form::select('weekdays', $weekdaysList, ['mon', 'tue', 'wed', 'thu', 'fri'], ['multiple', 'id' => 'weekdays', 'class' => 'selectpicker']) !!}
    </div>
    <div class="col-sm-1">
        {!! Form::label( trans('appointments.text.from') ) !!}<br>
        {!! Form::input('', null, $startAt, ['id' => 'start_at', 'class' => 'form-control']) !!}
    </div>
    <div class="col-sm-1">
        {!! Form::label( trans('appointments.text.to') ) !!}<br>
        {!! Form::input('', null, $finishAt, ['id' => 'finish_at', 'class' => 'form-control']) !!}
    </div>
    <div class="col-sm-1">
        {!! Form::label( trans('&nbsp;') ) !!}<br>
        {!! Button::withIcon(Icon::plus())->withAttributes(['id' => 'add']) !!}
    </div>
    <div class="col-sm-1">
        {!! Form::label( trans('&nbsp;') ) !!}<br>
        {!! Button::withIcon(Icon::trash())->withAttributes(['id' => 'reset']) !!}
    </div>
    
</div>

<br>
<textarea id="vacancies" name="vacancies" rows="8">
{{ $template }}
</textarea>
<br>

<input type="checkbox" name="unpublish" id="unpublish" value="true" />
<label for="unpublish">&nbsp;{{ trans('manager.businesses.check.unpublish_vacancies') }}</label>
<br>

<input type="checkbox" name="remember" id="remember" value="true" />
<label for="remember">&nbsp;{{ trans('manager.businesses.check.remember_vacancies') }}</label>
<br>

@if (!$business->services->isEmpty())
<div class="row">
    <div class="form-group col-sm-12">
        {!! Button::success(trans('manager.businesses.btn.update'))->block()->large()->submit() !!}
    </div>
</div>
@endif

@section('footer_scripts')
@parent
<script src="{{ asset('js/forms.js') }}"></script>
<script>
$(document).ready(function(){

    var statements = [];

    $('#reset').click(function(){
        statements = [];
        $('#vacancies').val('');
    });

    $('#add').click(function(){

        var staff = $('#staff').find(":selected").text();
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
        $('#services').selectpicker('deselectAll');
        $('#weekdays').selectpicker('deselectAll');
    }
});
</script>
@endsection