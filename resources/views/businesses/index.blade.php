@extends('app')

@section('content')

<div class='container'>
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