@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

<div class="form-group">
    {!! Form::label( trans('manager.humanresource.form.name.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-9 col-md-9">
        {!! Form::text('name', null, [
            'required',
            'class' => 'form-control',
            'placeholder' => old('name'),
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.humanresource.form.capacity.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-9 col-md-9">
        {!! Form::text('capacity', null, [
            'required',
            'class' => 'form-control',
            'type' => 'number',
            'step' => '1',
            'placeholder' => old('capacity'),
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<br/>

<div class="form-group">
    {!! Form::label( trans('manager.humanresource.form.calendar_link.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-9 col-md-9">
        {!! Form::text('calendar_link', null, [
            'class' => 'form-control',
            'placeholder' => old('calendar_link'),
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="col-xs-12">
    <div class="form-group">
        {!! Button::primary($submitLabel)->large()->block()->submit() !!}
    </div>
</div>
