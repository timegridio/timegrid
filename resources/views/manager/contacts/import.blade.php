@extends('app')

@section('content')
<div class="container">
    <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('manager.contacts.import.title') }}</div>

                <div class="panel-body">
                    @include('_errors')

                    {!! Form::open(['route' => ['manager.business.contact.import', $business->id], 'id' => 'import', 'data-toggle' => 'validator']) !!}
                    <div class="row">
                        <div class="form-group col-xs-12">
                            {!! Form::textarea('data', null, 
                                array('class'=>'form-control', 
                                      'placeholder'=> trans('manager.contacts.form.data.label') )) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="notes form-group col-xs-12">
                            {!! Button::primary(trans('manager.contacts.btn.import'))->block()->submit() !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
    </div>
</div>
@endsection
