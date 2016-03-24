<div id="panel" class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">{{ trans('user.appointments.form.timetable.title', ['business' => $business->name]) }}</div>

    <div id="catalog">
    @if($business->services->count() > 1)
    <input id="filter" name="filter" class="form-control" value="" />
    <div id="searchlist" class="list-group">
        @foreach ($business->services as $service)
        <a class="list-group-item service-selector" data-service-id="{{ $service->id }}" href="#"><span>{{ $service->name }}</span><i style="background:{{ $service->color }}" class="badge">&nbsp;</i></a>
        @endforeach
    </div>
    @endif
    </div>
    
    <table id="timetable" class="table hidden">
    @foreach ($dates as $date => $vacancies)
        @if (empty($vacancies))
        <tr class="daterow">
            <td class="dateslot disable">
                {!! Button::normal(Carbon::parse($date)->formatLocalized('%A %d %B'))
                    ->block()
                    ->disable()
                    ->prependIcon(Icon::calendar())
                    ->withAttributes(['class' => 'btn-date'])
                    !!}
            </td>
            <td class="serviceslot" >
                <p class="hidden-xs">
                    {!! Icon::remove() !!}&nbsp;&nbsp;{{ trans('user.appointments.form.timetable.msg.no_vacancies') }}
                </p>
                <p class="hidden-lg hidden-md hidden-sm">{!! Icon::remove() !!}&nbsp;&nbsp;{{ trans('N/D') }}</p>
            </td>
        </tr>
        @else
        <tr class="daterow date_{{ $date }}">
            <td class="dateslot">
                {!! Button::info(Carbon::parse($date)->formatLocalized('%A %d %B'))
                    ->block()
                    ->prependIcon(Icon::calendar())
                    ->withAttributes(['class' => 'btn-date']) !!}
            </td>
            <td class="serviceslot" >
                @foreach ($vacancies as $vacancy)
                {!! Button::success($vacancy->service->name)
                    ->prependIcon(Icon::ok())
                    ->withAttributes([
                        'title' => Carbon::parse($date)->formatLocalized('%A %d %B') . ' ' . $vacancy->service->name,
                        'class' => 'service service'.$vacancy->service_id,
                        'data-service' => $vacancy->service_id,
                        'data-date' => $vacancy->date]) !!}
                @endforeach
            </td>
        </tr>
        @endif
    @endforeach
    </table>

    <ul class="list-group">
    @foreach ($business->services as $service)
    @if($service->description)
        <li class="list-group-item list-group-item-info service-description hidden" id="service-description-{{$service->id}}">
        {{ $service->description }}
        </li>
    @endif

    @if($service->prerequisites)
    <li class="list-group-item list-group-item-warning service-prerequisites hidden" id="service-prerequisites-{{$service->id}}">
        {!! Icon::alert() !!} &nbsp;&nbsp; {{ trans('app.label.attention') }}: {{ $service->prerequisites }}
    </li>
    @endif
    @endforeach
    </ul>

    <div id="moreDates">
    {!! Button::primary(trans('user.appointments.btn.more_dates'))
        ->asLinkTo(route('user.booking.book', ['business' => $business, 'date' => date('Y-m-d', strtotime("$startFromDate +7 days"))]))
        ->small()
        ->block()!!}
    </div>

</div>

@section('footer_scripts')
@parent
<script type="text/javascript">
$(document).ready(function() {

    $('#searchlist').btsListFilter('#filter', {itemChild: 'span'});

    $('.service-selector').click(function(e){
        var serviceId = $(this).data('service-id');
        $('.service').hide();
        $('.service' + serviceId).show();
        $('#catalog').hide();
        $('#timetable').show();
    });

    $('#timetable').removeClass('hidden').hide();
    $('#extra').removeClass('hidden').hide();

    $('#timetable .btn.service').click(function(e){
        var service = $(this).data('service');
        console.log('Press ' + service);
        $('.service-prerequisites').hide();
        $('#service-prerequisites-'+service).removeClass('hidden').show();
        $('.service-description').hide();
        $('#service-description-'+service).removeClass('hidden').show();
        $('.service').removeClass('btn-success');
        $('#date').val( $(this).data('date') );
        $('#service').val( $(this).data('service') );
        $(this).toggleClass('btn-success');
        $('tr:not(.date_'+$(this).data('date')+')').hide();
        $('#extra').show();

        var business = $('#business').val();
        var date = $('#date').val();
        var service = $('#service').val();

        var timesSelect = $('#times');
        var durationInput = $('#duration');

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
                $('#moreDates').hide();
                $('#extra').show();
            },
            fail: function ( data ) {
                durationInput.val(0);
            }
        });

    });

    $('#timetable .btn.btn-date').click(function(e){
        $('.daterow').show();
        $('#extra').hide();
        $('#moreDates').show();
    });
    $('#date').click(function(e){
        $('#panel').show();
        $('#extra').hide();
        $('#moreDates').show();
        return false;
    });

    @if($business->services->count() <= 1)
    $('#timetable').show();
    @endif
});
</script>
@endsection