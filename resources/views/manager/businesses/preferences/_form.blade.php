@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection
{{-- $preferences->findBy(['key' => $key]) --}}

{{-- [META] Translation keys for potsky/laravel-localization-helpers -dev
trans('preferences.App\Models\Business.appointment_cancellation_pre_hs.format')
trans('preferences.App\Models\Business.appointment_cancellation_pre_hs.help')
trans('preferences.App\Models\Business.appointment_cancellation_pre_hs.label')
trans('preferences.App\Models\Business.appointment_code_length.format')
trans('preferences.App\Models\Business.appointment_code_length.help')
trans('preferences.App\Models\Business.appointment_code_length.label')
trans('preferences.App\Models\Business.appointment_take_today.format')
trans('preferences.App\Models\Business.appointment_take_today.help')
trans('preferences.App\Models\Business.appointment_take_today.label')
trans('preferences.App\Models\Business.show_map.format')
trans('preferences.App\Models\Business.show_map.help')
trans('preferences.App\Models\Business.show_map.label')
trans('preferences.App\Models\Business.show_phone.format')
trans('preferences.App\Models\Business.show_phone.help')
trans('preferences.App\Models\Business.show_phone.label')
trans('preferences.App\Models\Business.show_postal_address.format')
trans('preferences.App\Models\Business.show_postal_address.help')
trans('preferences.App\Models\Business.show_postal_address.label')
trans('preferences.App\Models\Business.start_at.format')
trans('preferences.App\Models\Business.start_at.help')
trans('preferences.App\Models\Business.start_at.label')
--}}
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
    @if ($value['type'] == 'time')
        {!! Form::label( trans('preferences.App\Models\Business.'.$key.'.label') ) !!}
        {!! Form::time($key, $business->pref($key),
            array('class'=>'form-control',
                  'placeholder'=> trans('preferences.App\Models\Business.'.$key.'.format'),
                  'title'=> trans('preferences.App\Models\Business.'.$key.'.help') )) !!}
    @endif
    @if ($value['type'] == 'int')
        {!! Form::label( trans('preferences.App\Models\Business.'.$key.'.label') ) !!}
        <div class="input-group">
        @if($icon = array_get($value, 'icon'))
            <span class="input-group-addon">{!! Icon::create($icon) !!}</span>
        @endif
        {!! Form::number($key, $business->pref($key),
            array('class'=>'form-control',
                  'step' => array_get($value, 'step', 5),
                  'placeholder'=> trans('preferences.App\Models\Business.'.$key.'.format'),
                  'title'=> trans('preferences.App\Models\Business.'.$key.'.help') )) !!}
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