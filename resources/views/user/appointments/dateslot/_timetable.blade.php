<div id="panel" class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">{{ trans('user.appointments.form.timetable.title') }}</div>
  <div class="panel-body">
    <p>{{ trans('user.appointments.form.timetable.instructions') }}</p>
  </div>

<table id="timetable" class="table table-condensed">
@foreach ($vacancies as $date)
<tr class="daterow date_{{ $date[0]->date }}">
  <td class="dateslot success">
    {!! Button::normal(Carbon::parse($date[0]->date)->formatLocalized('%A %d %B %Y'))->prependIcon(Icon::calendar())->withAttributes(['class' => 'btn-date']) !!}
  </td>
    <td class="serviceslot" >
      @foreach ($date as $vacancy)
        {!! Button::primary($vacancy->service->name)->prependIcon(Icon::ok())->withAttributes(['class' => 'service service'.$vacancy->service_id, 'data-service' => $vacancy->service_id, 'data-date' => $vacancy->date]) !!}
      @endforeach
    </td>
  </tr>
@endforeach
</table>
</div>

@section('footer_scripts')
@parent
<script type="text/javascript">
$(document).ready(function() {
    $('#extra').removeClass('hidden').hide();
    $('#timetable .btn.service').click(function(e){
        console.log('Press '+$(this).data('service'));
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