@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
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
    @else
        {{-- Keep it simple, nothing to display --}}
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
    <div class="col-xs-12">
        <div class="form-group">
            {!! Button::primary($submitLabel)->large()->block()->submit() !!}
        </div>
    </div>
</div>

@section('footer_scripts')
@parent
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

    $('selectpicker').addClass('dropupAuto');
    $('selectpicker').selectpicker({ size: 1 });

});
</script>
@endsection