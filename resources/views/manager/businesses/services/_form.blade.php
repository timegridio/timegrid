@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

<div class="form-group">
    {!! Form::label( trans('manager.service.form.name.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
        {!! Form::text('name', null, [
            'required',
            'class'=>'form-control',
            'placeholder'=> trans('manager.service.form.name.label')
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.service.form.duration.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-3 col-md-3">
        <div class="input-group">
            <span class="input-group-addon">{!! Icon::hourglass() !!}</span>
            {!! Form::number('duration', null, [
                'required',
                'step' => 5,
                'class'=>'form-control',
                'placeholder'=> trans('manager.service.form.duration.label')
                ]) !!}
        </div>
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.description.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::textarea('description', null, [
        'class'=>'form-control',
        'rows'=> '3',
        'placeholder'=> trans('manager.contacts.form.description.label')
        ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.contacts.form.prerequisites.label'), null, ['class' => 'control-label col-sm-3'] ) !!}
    <div class="col-sm-9">
    {!! Form::textarea('prerequisites', null, [
        'class'=>'form-control',
        'rows'=> '3',
        'placeholder'=> trans('manager.contacts.form.prerequisites.label')
        ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

@if($types->count() > 0)
<div class="form-group">
    {!! Form::label( trans('manager.service.form.servicetype.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-9 col-md-9">
        <div class="input-group">
            {!! Form::select('type_id', $types, null, ['name' => 'type_id', 'class' => 'select2']) !!}
        </div>
        <div class="help-block with-errors"></div>
    </div>
</div>
@endif

<div class="form-group">
    {!! Form::label( trans('manager.service.form.color.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-4 col-md-4">
        <div class="input-group color-picker">
            {!! Form::text('color', null, [
                'class'=>'form-control',
                'placeholder'=> trans('manager.service.form.color.label')
                ]) !!}
            <span class="input-group-addon"><i></i></span>
        </div>
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="col-xs-12">
    <div class="form-group">
        {!! Button::primary($submitLabel)->large()->block()->submit() !!}
    </div>
</div>

@push('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

    $('.select2').select2({ theme: 'boostrap' });
    // $('.selectpicker').addClass('dropupAuto');
    // $('.selectpicker').select2({ size: 4 });

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
@endpush