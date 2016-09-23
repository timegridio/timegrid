<div id="panel" class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">{{ trans('user.appointments.form.timetable.title') }}</div>
    <div class="panel-body">
        {!! Alert::info(trans('user.appointments.form.timetable.instructions')) !!}

        <div class="row">
            <div class="form-group col-sm-12">
                @foreach ($business->services as $service)
                @if($service->description)
                    <div class="well service-description hidden" id="service-description-{{$service->id}}">
                        <strong>{{$service->name}}:</strong>&nbsp;{{ $service->description }}
                    </div>
                @endif
                @if($service->prerequisites)
                    {!! Panel::warning()->withHeader(Icon::alert() ."&nbsp;&nbsp;". trans('app.label.attention'))
                        ->withBody("<pre>{$service->prerequisites}</pre>")
                        ->withAttributes([
                            'class' => 'service-prerequisites hidden',
                            'id' => "service-prerequisites-{$service->id}"]) !!}
                @endif
                @endforeach
            </div>
        </div>

    <div id="moreDates">
    {!! Button::primary(trans('user.appointments.btn.more_dates'))
        ->asLinkTo(route('user.booking.book', ['business' => $business, 'date' => date('Y-m-d', strtotime("$startFromDate +7 days"))]))
        ->small()
        ->block() !!}
    </div>

    </div>

    <table id="timetable" class="table table-condensed table-hover">
    @foreach ($dates as $date => $vacancies)
        @if (empty($vacancies))
        <tr class="daterow">
            <td class="dateslot disable">
                {!! Button::normal(Carbon::parse($date)->formatLocalized('%A %d %B'))
                    ->block()
                    ->disable()
                    ->prependIcon(Icon::calendar())
                    ->withAttributes(['class' => 'btn-date']) !!}
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
                {!! Button::success(Carbon::parse($date)->formatLocalized('%A %d %B'))
                    ->block()
                    ->prependIcon(Icon::calendar())
                    ->withAttributes(['class' => 'btn-date']) !!}
            </td>
            <td class="serviceslot" >
                @foreach ($vacancies as $vacancy)
                {!! Button::primary($vacancy->service->name)
                    ->prependIcon(Icon::ok())
                    ->withAttributes([
                        'class' => 'service service'.$vacancy->service_id,
                        'data-service' => $vacancy->service_id,
                        'data-date' => $vacancy->date]) !!}
                @endforeach
            </td>
        </tr>
        @endif
    @endforeach
    </table>
</div>

@push('footer_scripts')
<script type="text/javascript">
$(document).ready(function() {
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
    });
    $('#timetable .btn.btn-date').click(function(e){
        $('.daterow').show();
        $('#extra').hide();
    });
    $('#date').click(function(e){
        $('#panel').show();
        return false;
    });
});
</script>
@endpush