@foreach ($appointments as $appointment)
    {!! $appointment->widget()->panel() !!}
@endforeach