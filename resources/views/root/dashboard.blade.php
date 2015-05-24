@extends('root.app')

@section('content')
<div class="container">
	
	<h1>Registered Users</h1>
	<table class="table table-condensed">
	@foreach ($users as $user)
	<tr>
	  <td >{{ $user->id }}</td>
	  <td >{{ $user->email }}</td>
	  
	  <td >{{ $user->created_at }}</td>
	  <td >{{ $user->updated_at }}</td>
	</tr>
	@endforeach
	</table>

</div>
@endsection
