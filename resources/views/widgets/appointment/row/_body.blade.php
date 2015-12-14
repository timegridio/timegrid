{{-- Appointment Row Partial --}}
<tr id="{{ $appointment->code }}" class="{{ $appointment->statusToCssClass }}">
    <td>{{ $appointment->status }}</td>
    <td>{{ $appointment->code }}</td>
    <td>{{ $appointment->contact->firstname }} {{ $appointment->contact->lastname }}</td>
    <td>{{ $appointment->date }}</td>
    <td title="{{ $appointment->timezone }}">{{ $appointment->time }}</td>
    <td>{{ $appointment->business->name }}</td>
    <td>{{ $appointment->service->name }}</td>
    <td>{{ $appointment->diffForHumans }}</td>
    <td>
        <div class="btn-group">
            @include('widgets.appointment.row._buttons', ['appointment' => $appointment, 'user' => $user])
        </div>
    </td>
</tr>