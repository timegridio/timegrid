@extends('app')

@section('content')

<div class='container'>

	@include('flash::message')

	<table class="table table-condensed">
		<tr>
			<td>{!! Button::primary($business->slug)->asLinkTo(action('BusinessesController@edit', $business)) !!}</td>
			<td>{{ $business->name }}</td>
			<td>{{ $business->description }}</td>
		</tr>
	</table>
</div>

@endsection