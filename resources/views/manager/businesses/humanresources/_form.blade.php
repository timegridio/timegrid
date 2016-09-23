@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

<div class="container-fluid">

    <div class="row">
        <div class="form-group">
            {!! Form::text('name', null, [
                'required',
                'class'=>'form-control',
                'placeholder'=> trans('manager.humanresource.form.name.label')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Form::text('capacity', null, [
                'required',
                'class'=>'form-control',
                'placeholder'=> trans('manager.humanresource.form.capacity.label')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {!! Form::text('calendar_link', null, [
                'class'=>'form-control',
                'placeholder'=> trans('manager.humanresource.form.calendar_link.label')
                ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                {!! Button::primary($submitLabel)->large()->block()->submit() !!}
            </div>
        </div>
    </div>

</div>