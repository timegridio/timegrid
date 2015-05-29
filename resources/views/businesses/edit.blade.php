@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<h1>Contact TODOParrot</h1>
		
		<ul>
		    @foreach($errors->all() as $error)
		        <li>{{ $error }}</li>
		    @endforeach
		</ul>

		{!! Form::model($business, ['method' => 'put', 'route' => ['businesses.update', $business->id]]) !!}

		<div class="form-group">
		    {!! Form::label('Slug') !!}
		    {!! Form::text('slug', null, 
		        array('required', 
		              'class'=>'form-control', 
		              'placeholder'=>'Your business slug')) !!}
		</div>
		
		<div class="form-group">
		    {!! Form::label('Name') !!}
		    {!! Form::text('name', null, 
		        array('required', 
		              'class'=>'form-control', 
		              'placeholder'=>'Your business name')) !!}
		</div>

		<div class="form-group">
		    {!! Form::label('Description') !!}
		    {!! Form::textarea('description', null, 
		        array('required', 
		              'class'=>'form-control', 
		              'placeholder'=>'Describe your business')) !!}
		</div>
		
		<div class="form-group">
		    {!! Button::primary('Submit')->submit() !!}
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection
