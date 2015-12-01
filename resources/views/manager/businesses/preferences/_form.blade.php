@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
@endsection
{{-- $preferences->findBy(['key' => $key]) --}}

<div class="col-md-12">
@foreach ($parameters as $key => $value)
<div class="row">
    @if ($value['type'] == 'bool')
        {!! Form::label( trans('preferences.App\Models\Business.'.$key.'.label') ) !!}
        {!! Form::select($key, ['0' => trans('preferences.controls.select.no'), '1' => trans('preferences.controls.select.yes')], $business->pref($key),
            array('class'=>'form-control', 'title'=> trans('preferences.App\Models\Business.'.$key.'.help'))) !!}
    @endif
    @if ($value['type'] == 'string')
        {!! Form::label( trans('preferences.App\Models\Business.'.$key.'.label') ) !!}
        {!! Form::text($key, $business->pref($key),
            array('class'=>'form-control',
                  'placeholder'=> trans('preferences.App\Models\Business.'.$key.'.format'),
                  'title'=> trans('preferences.App\Models\Business.'.$key.'.help') )) !!}
    @endif
    @if ($value['type'] == 'int')
        {!! Form::label( trans('preferences.App\Models\Business.'.$key.'.label') ) !!}
        {!! Form::number($key, $business->pref($key),
            array('class'=>'form-control',
                  'placeholder'=> trans('preferences.App\Models\Business.'.$key.'.format'),
                  'title'=> trans('preferences.App\Models\Business.'.$key.'.help') )) !!}
    @endif
        <div class="help-block with-errors"></div>
</div>
@endforeach
</div>


<p>&nbsp;</p>

<div class="row">
    <div class="form-group col-md-12">
        {!! Button::primary(trans('app.btn.update'))->large()->block()->submit() !!}
    </div>
</div>

@section('footer_scripts')
@parent
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
@endsection