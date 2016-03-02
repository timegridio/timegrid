@foreach ($appointments as $appointment)
    {!! $appointment->panel() !!}
@endforeach