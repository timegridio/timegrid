@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				
        <div class="panel-heading">{{ trans('user.appointments.index.title') }}</div>

				<div class="panel-body">
          <table class="table table-condensed">
            @foreach ($appointments as $appointment)
              <tr>
                <td><code>{{ $appointment->code }}</code></td>
                <td>{{ $appointment->status }}</td>
                <td>{{ $appointment->start_at->timezone($appointment->tz)->toDateString() }}</td>
                <td title="{{ $appointment->tz }}">{{ $appointment->start_at->timezone($appointment->tz)->toTimeString() }}</td>
                <td title="{{ $appointment->tz }}">{{ $appointment->finish_at->timezone($appointment->tz)->toTimeString() }}</td>
                <td>{{ $appointment->duration }}</td>
                <td>{{ $appointment->business->name }}</td>
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
