<h3>{{ trans('booking.steps.title.pick-a-time') }}</h3>

<section>
<div class="container-fluid">
    <div class="row">
        <div class="form-group col-sm-12">
            <span id="timezoneIndicator"></span>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-12">
            <label for="comments">{{ trans('user.appointments.form.time.label') }}</label>
            <br/>
            <select id="times" name="_time" class="form-control"></select>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-12">
            {!! Button::primary(trans('booking.btn.pick-this-time'))->withAttributes(['id' => 'pick-this-time'])->block() !!}
        </div>
    </div>

</div>
</section>

@section('footer_scripts')
@parent
<script>
$(document).ready(function() {

    $('#pick-this-time').click(function(e){
        var timePicker = $('#times');
        timePicker.change();
        e.preventDefault();
    });

});
</script>
@endsection