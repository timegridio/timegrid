@foreach ($appointments as $appointment)
    {!! Widget::AppointmentPanel(['appointment' => $appointment, 'user' => auth()->user()]) !!}
@endforeach