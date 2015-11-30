<tr id="{{ $appointment->code() }}" class="{{ $class }}">
    <td>{{ $appointment->status() }}</td>
    <td>{{ $appointment->code() }}</td>
    <td>{{ $appointment->contact->firstname }}</td>
    <td>{{ $appointment->date() }}</td>
    <td title="{{ $appointment->tz }}">{{ $appointment->start_at->timezone($appointment->tz)->toTimeString() }}</td>
    <td>{{ $appointment->service->name }}</td>
    <td>{{ $appointment->business->name}}</td>
    <td>{{ $appointment->start_at->diffForHumans() }}</td>
    <td>{!! $actionButtons !!}</td>
</tr>