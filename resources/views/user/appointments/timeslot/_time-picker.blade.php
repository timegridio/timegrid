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
</div>
</section>
