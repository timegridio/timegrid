@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
<style>
textarea{
    font-size: 1.5em;
    font-family: Monospace;
    border: 0;
    color: #555;
    line-height: 2em;
    width: 100%;
}
</style>
@endsection

{{-- Services Form Partial --}}
<div class="row">
<textarea name="servicetypes" rows="6">
@foreach($servicetypes as $servicetype)
{{ $servicetype->name }}:{{ $servicetype->description }}
@endforeach
</textarea>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            {!! Button::primary($submitLabel)->large()->block()->submit() !!}
        </div>
    </div>
</div>

@section('footer_scripts')
@parent
<script src="{{ asset('js/forms.js') }}"></script>
@endsection