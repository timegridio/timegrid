@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

<div class="row">

    <div class="form-group col-xl-6 col-md-6 col-sm-4 col-xs-4">
        {!! Form::text('name', null, [
            'required',
            'class'=>'form-control',
            'placeholder'=> trans('manager.humanresource.form.name.label')
            ]) !!}
    </div>

    <div class="form-group col-xl-6 col-md-6 col-sm-4 col-xs-4">
        {!! Form::text('capacity', null, [
            'required',
            'class'=>'form-control',
            'placeholder'=> trans('manager.humanresource.form.capacity.label')
            ]) !!}
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                {!! Button::primary($submitLabel)->large()->block()->submit() !!}
            </div>
        </div>
    </div>

</div>
