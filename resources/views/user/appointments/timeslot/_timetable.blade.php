@section('css')
@parent
<style>
.date {
    color: #777777;
    background: #eaeaea;
    display: inline-block;
    margin-bottom: 0;
    font-weight: 300;
    text-align: center;
    vertical-align: middle;
    background-image: none;
    border: 1px solid transparent;
    white-space: nowrap;
    padding: 10px 15px;
    font-size: 15px;
    line-height: 1.42857143;
    border-radius: 4px;
    width: 100%;
}

.date-active {
    color: #333333;
    background: #eaeaea;
}

.date-muted {
    color: #999999;
    background: #d9d9d9;
}
</style>
@endsection

<div id="panel" class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">{{ trans('user.appointments.alert.book_in_biz_on_behalf_of', ['biz' => $business->name, 'contact' => $contact->fullname()]) }}</div>

    <div id="catalog">
    @if($business->services->count() > 1)
        @if($business->services->count() > 10)
        <input id="filter" name="filter" class="form-control" value="" />
        @endif
    <div id="searchlist" class="list-group">
        @foreach ($business->services as $service)
        <a class="list-group-item service-selector" data-service-id="{{ $service->id }}" href="#">
            <span>{{ $service->name }}</span>
            @if($service->duration)
            <span class="text-muted pull-right">({{ trans_duration("{$service->duration} minutes") }})
            @endif
            @if($service->color)
            &nbsp;&nbsp;<i style="background:{{ $service->color }}" class="badge">&nbsp;</i>
            @endif
            </span>
        </a>
        @endforeach
    </div>
    @endif
    </div>

    <table id="timetable" class="table hidden">
    @foreach ($dates as $date => $vacancies)
        @if (empty($vacancies))
        <tr class="daterow">
            <td class="dateslot">
                <div class="date date-muted">
                    {!! Icon::calendar() !!}&nbsp;{{ (Carbon::parse($date)->formatLocalized('%A %d %B')) }}
                </div>
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
                <div class="date date-active">
                    {!! Icon::calendar() !!}&nbsp;{{ (Carbon::parse($date)->formatLocalized('%A %d %B')) }}
                </div>
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
        <li class="list-group-item service-description hidden" id="service-description-{{$service->id}}">
        {!! Markdown::convertToHtml($service->description) !!}
        </li>
    @endif

    @if($service->prerequisites)
    <li class="list-group-item service-prerequisites hidden" id="service-prerequisites-{{$service->id}}">
        {!! Markdown::convertToHtml($service->prerequisites) !!}
    </li>
    @endif
    @endforeach
    </ul>

    <div>
    {!! Button::primary()
        ->withIcon(Icon::eject())
        ->withAttributes(['id' => 'restoreDates', 'class' => 'hidden'])
        ->small()
        ->block() !!}

    {!! Button::primary(trans('user.appointments.btn.more_dates'))
        ->withAttributes(['id' => 'moreDates', 'class' => 'hidden'])
        ->asLinkTo(route('user.booking.book', ['business' => $business, 'date' => date('Y-m-d', strtotime("$startFromDate +7 days"))]))
        ->small()
        ->block() !!}
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
        $('#moreDates').show();
        $('#timetable').show();
    });

    $('#timetable').removeClass('hidden').hide();
    $('#extra').removeClass('hidden').hide();

    $('#timetable .btn.service').click(function(e){
        var service = $(this).data('service');
        // console.log('Press ' + service);
        $('.service-description').hide();
        $('.service-prerequisites').hide();
        $('tr:not(.date_'+$(this).data('date')+')').hide();
        
        $('#service-prerequisites-'+service).removeClass('hidden').show();
        $('#service-description-'+service).removeClass('hidden').show();
        
        $('.service').removeClass('btn-success');
        
        $('#date').val( $(this).data('date') );
        $('#service').val( $(this).data('service') );
        
        $(this).toggleClass('btn-success');
        
        $('#extra').show();
        $('#restoreDates').show();

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
                $('#moreDates').hide();
                $('#extra').show();

                timesSelect.find('option').remove();
                $.each(data.times,function(key, value)
                {
                    timesSelect.append('<option value=' + value + '>' + value + '</option>');
                });
                durationInput.val(data.service.duration);
            },
            fail: function ( data ) {
                durationInput.val(0);
            }
        });

    });

    $('#restoreDates').click(function(e){
        $('.daterow').show();
        $('#panel').show();
        $('#extra').hide();
        $('#moreDates').show();
        $(this).hide();
        return false;
    });

    $('#moreDates').hide();
    $('#restoreDates').hide();
    $('#moreDates').removeClass('hidden');
    $('#restoreDates').removeClass('hidden');

    @if($business->services->count() <= 1)
    $('#timetable').show();
    @endif
});
</script>
@endsection