@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('user.businesses.suscriptions.title') }}</div>

				<div class="panel-body">
					@include('flash::message')
				
					<table class="table table-condensed">
					@foreach ($contacts as $contact)
						<tr>
							<td>{{ $contact->nin }}</td>
              <td>{{ $contact->firstname }}</td>
              <td>{{ $contact->lastname }}</td>
              <td>{{ $contact->email }}</td>
						</tr>
					@endforeach
					</table>
				</div>

				<div class="panel-footer">

				</div>

			</div>
		</div>
	</div>
</div>

@endsection