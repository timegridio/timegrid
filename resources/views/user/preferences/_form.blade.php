@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

<div class="col-md-12">
@foreach ($parameters as $key => $value)
<div class="row">
    @if ($value['type'] == 'bool')
        {!! Form::label( trans('preferences.App\Models\User.'.$key.'.label') ) !!}
        {!! Form::select($key, ['0' => trans('preferences.controls.select.no'), '1' => trans('preferences.controls.select.yes')], $user->pref($key),
            array('class'=>'form-control', 'title'=> trans('preferences.App\Models\User.'.$key.'.help'))) !!}
    @endif
    @if ($value['type'] == 'string')
        {!! Form::label( trans('preferences.App\Models\User.'.$key.'.label') ) !!}
        {!! Form::text($key, $user->pref($key),
            array('class'=>'form-control',
                  'placeholder'=> trans('preferences.App\Models\User.'.$key.'.format'),
                  'title'=> trans('preferences.App\Models\User.'.$key.'.help') )) !!}
    @endif
    @if ($value['type'] == 'time')
        {!! Form::label( trans('preferences.App\Models\User.'.$key.'.label') ) !!}
        {!! Form::time($key, $user->pref($key),
            array('class'=>'form-control',
                  'placeholder'=> trans('preferences.App\Models\User.'.$key.'.format'),
                  'title'=> trans('preferences.App\Models\User.'.$key.'.help') )) !!}
    @endif
    @if ($value['type'] == 'int')
        {!! Form::label( trans('preferences.App\Models\User.'.$key.'.label') ) !!}
        <div class="input-group">
        @if($icon = array_get($value, 'icon'))
            <span class="input-group-addon">{!! Icon::create($icon) !!}</span>
        @endif
        {!! Form::number($key, $user->pref($key),
            array('class'=>'form-control',
                  'step' => array_get($value, 'step', 5),
                  'placeholder'=> trans('preferences.App\Models\User.'.$key.'.format'),
                  'title'=> trans('preferences.App\Models\User.'.$key.'.help') )) !!}
        </div>
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

@push('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>
@endpush