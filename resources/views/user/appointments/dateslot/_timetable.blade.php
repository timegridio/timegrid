<div id="panel" class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">{{ trans('user.appointments.form.timetable.title') }}</div>
  <div class="panel-body">
    <p>{{ trans('user.appointments.form.timetable.instructions') }}</p>

    <div class="row">
        <div class="form-group col-sm-12">
        @foreach ($business->services as $service)
          @if($service->description)
            <div class="well service-description" id="service-description-{{$service->id}}"><strong>{{$service->name}}:</strong>&nbsp;{{ $service->description }}</div>
          @endif
        @endforeach
        </div>
    </div>

  </div>

<table id="timetable" class="table table-condensed table-hover">
@foreach ($dates as $date => $vacancies)
@if (!empty($vacancies))
<tr class="daterow date_{{ $date }}">
  <td class="dateslot success">
    {!! Button::normal(Carbon::parse($date)->formatLocalized('%A %d %B'))->block()->prependIcon(Icon::calendar())->withAttributes(['class' => 'btn-date']) !!}
  </td>
    <td class="serviceslot" >
      @foreach ($vacancies as $vacancy)
        {!! Button::primary($vacancy->service->name)->prependIcon(Icon::ok())->withAttributes(['class' => 'service service'.$vacancy->service_id, 'data-service' => $vacancy->service_id, 'data-date' => $vacancy->date]) !!}
      @endforeach
    </td>
  </tr>
@else
<tr class="daterow">
  <td class="dateslot disable">
    {!! Button::normal(Carbon::parse($date)->formatLocalized('%A %d %B'))->block()->disable()->prependIcon(Icon::calendar())->withAttributes(['class' => 'btn-date']) !!}
  </td>
    <td class="serviceslot" >
        <p class="hidden-xs">{!! Icon::remove() !!}&nbsp;&nbsp;{{ trans('user.appointments.form.timetable.msg.no_vacancies') }}</p>
        <p class="hidden-lg hidden-md hidden-sm">{!! Icon::remove() !!}&nbsp;&nbsp;{{ trans('N/D') }}</p>
    </td>
  </tr>
@endif
@endforeach
</table>
</div>

@section('footer_scripts')
@parent
<script type="text/javascript">
$(document).ready(function() {
    $('#extra').removeClass('hidden').hide();
    $('#timetable .btn.service').click(function(e){
        var service = $(this).data('service');
        console.log('Press ' + service);
        $('.service-description').hide();
        $('#service-description-'+service).show();
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
@endsection