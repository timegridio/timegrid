@extends('app')

@section('content')

<div class='container'>

	@include('flash::message')

	<table class="table table-condensed">
	@foreach ($businesses as $business)
		<tr>
			<td>{{ $business->slug }}</td>
			<td>{{ $business->name }}</td>
			<td>{{ $business->description }}</td>
		</tr>
	@endforeach
	</table>
</div>

@endsection