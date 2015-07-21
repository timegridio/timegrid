@foreach ($appointments as $appointment)
    {!! $appointment->widget()->actions()->panel() !!}
@endforeach