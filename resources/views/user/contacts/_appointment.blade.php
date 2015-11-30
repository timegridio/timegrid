@foreach ($appointments as $appointment)
    {!! Widget::AppointmentPanel(['appointment' => $appointment, 'user' => \Auth::user()]) !!}
@endforeach