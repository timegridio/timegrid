@foreach($timetable as $date => $services)
<div class="col-md-2">

    @foreach($services as $service => $times)
    
        <div class="panel panel-default">

            <div class="panel-heading">{!! Icon::calendar() !!}&nbsp;{{ $date }}</div>
    
            <div class="panel-body">
                <p>{!! Icon::tag() !!}&nbsp;{{ $service }}</p>
            </div>
            
            @include('manager.businesses.vacancies._services', ['date' => $date, 'times' => $times])
        
            <div class="panel-footer">{{ $service }}</div>
        
        </div>

    @endforeach

</div>
@endforeach
