@foreach ($appointments as $appointment)
    {!! Widget::AppointmentPanel(['appointment' => $appointment, 'user' => $user]) !!}
@endforeach