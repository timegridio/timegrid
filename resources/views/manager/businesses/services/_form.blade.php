{{-- Services Form Partial --}}
<div class="row">
    <div class="form-group col-xs-6">
        {!! Form::text('name', null, [
            'required',
            'class'=>'form-control',
            'placeholder'=> trans('manager.service.form.name.label')
            ]) !!}
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