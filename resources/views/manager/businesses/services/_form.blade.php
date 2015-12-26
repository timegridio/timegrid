@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

{{-- Services Form Partial --}}
<div class="row">
    <div class="form-group col-xl-6 col-md-6 col-sm-4 col-xs-4">
        {!! Form::text('name', null, [
            'required',
            'class'=>'form-control',
            'placeholder'=> trans('manager.service.form.name.label')
            ]) !!}
    </div>
    <div class="form-group col-xl-2 col-md-2 col-sm-4 col-xs-4">
        <div class="input-group">
            <span class="input-group-addon">{!! Icon::hourglass() !!}</span>
                {!! Form::number('duration', null, [
                    'required',
                    'step' => 5,
                    'class'=>'form-control',
                    'placeholder'=> trans('manager.service.form.duration.label')
                    ]) !!}
        </div>
    </div>
    <div class="form-group col-xl-4 col-md-4 col-sm-4 col-xs-4">
    @if($types->count() > 0)
        <div class="input-group">
            {!! Form::select('type_id', $types, null, ['name' => 'type_id', 'class' => 'selectpicker']) !!}
        </div>
    @endif
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::textarea('description', null, [
                'class'=>'form-control',
                'rows'=> '3',
                'placeholder'=> trans('manager.contacts.form.description.label')
                ]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::textarea('prerequisites', null, [
                'class'=>'form-control',
                'rows'=> '3',
                'placeholder'=> trans('manager.contacts.form.prerequisites.label')
                ]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-xl-2 col-md-2 col-sm-2 col-xs-2">
        <div class="input-group color-picker">
            <input name="color" type="text" value="" class="form-control" readonly />
            <span class="input-group-addon"><i></i></span>
        </div>
    </div>
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
<script type="text/javascript">
$(document).ready(function(){

    $('selectpicker').addClass('dropupAuto');
    $('selectpicker').selectpicker({ size: 1 });

    $('.color-picker').colorpicker({
      colorSelectors: {
        '#BF4D28': '#BF4D28',
        '#E6AC27': '#E6AC27',
        '#F6F7BD': '#F6F7BD',
        '#80BCA3': '#80BCA3',
        '#655643': '#655643',
        '#6C2D58': '#6C2D58',
        '#B2577A': '#B2577A',
        '#B2577A': '#B2577A',
        '#F6B17F': '#F6B17F'
      }
    });

});
</script>
@endsection