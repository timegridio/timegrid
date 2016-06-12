@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/datetime.css') }}">
<style>
.datepicker table tr td.day {
    padding: 4px;
    border-radius: 0px;
}
.datepicker table tr td.day, .datepicker table tr td.day:hover {
    font-weight: bolder;
    color: #00A65A;
    border-bottom: 2px solid #00A65A;
}
.datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
    font-weight: bolder;
    color: #F5F5F5;
    border-bottom: 2px solid #F5F5F5;
    cursor: default;
}
.datepicker table tr td.today.disabled, .datepicker table tr td.today.disabled:active {
    background: #DDB0AA;
    color: #DD4B39;
    border-bottom: 2px solid #DD4B39;
}
.datepicker table tr td.today, .datepicker table tr td.today:hover {
    font-weight: bolder;
    color: #DD4B39;
    border-bottom: 2px solid #DD4B39;
    cursor: default;
}
</style>
@endsection

<h3>{{ trans('booking.steps.title.pick-a-date') }}</h3>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="form-group col-md-4 col-md-offset-4">
                <div id="datepicker"></div>
            </div>
        </div>
    </div>
</section>

@section('footer_scripts')
@parent
<script src="{{ asset('js/datetime.js') }}" ></script>
<script>
$(document).ready(function() {

    $('#datepicker').datepicker({
        language: timegrid.language,
        format: 'yyyy-m-d',
        startDate: timegrid.startDate,
        endDate: timegrid.endDate,
        datesDisabled: false,
        inline: true,
        todayHighlight: true,
        // daysOfWeekDisabled: '0',
        debug: true
    }).on('changeDate', function(e) {

        var business = $('#business').val();
        var service = $('#service').val();
        var date = $('#date').val();

        var timesSelect = $('#times');
        var durationInput = $('#duration');
        var timezoneInput = $('#timezone');
        var timezoneIndicator = $('#timezoneIndicator');

        var day = e.date.getDate();
        var month = e.date.getMonth() + 1;
        var year = e.date.getFullYear();

        var date = day + '-' + month + '-' + year;

        $('#date').val( date );
        $('#date').change();

        $.ajax({
            url:'/api/vacancies/' + business + '/' + service + '/' + date,
            type:'GET',
            dataType: 'json',
            success: function( data ) {

                timesSelect.find('option').remove();
                $.each(data.times,function(key, value)
                {
                    timesSelect.append('<option value=' + value + '>' + value + '</option>');
                });
                durationInput.val(data.service.duration);
                timezoneInput.val(data.timezone);
                timezoneIndicator.text(data.timezone);
                timesSelect.attr('title', data.timezone);
            },
            fail: function ( data ) {
                durationInput.val(0);
            }
        });

    });

});
</script>
@endsection