{{-- Appointment Row Partial --}}
<tr id="{{ $appointment->code }}">
    <td><code>{{ $appointment->code }}</code></td>
    <td><span class="label label-{!! $appointment->statusToCssClass() !!}">{{ $appointment->status() }}</td>
    <td>{{ $appointment->date('d/M') }}</td>
    <td title="{{ $appointment->timezone() }} {{ $appointment->start_at->diffForHumans() }}">{{ $appointment->time }}</td>
    <td title="{{ $appointment->timezone() }}">{{ $appointment->finishTime }}</td>
    <td>{{ trans_duration($appointment->duration()) }}</td>
    <td>{{ $appointment->service ? $appointment->service->name : '' }}</td>
    <td>{{ $appointment->contact->fullname }}</td>
    <td>
    @include('widgets.appointment.row._buttons', ['appointment' => $appointment, 'user' => $appointment->contact->user])
    </td>
</tr>