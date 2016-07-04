<table style="width:100%; max-width: 600px; border: #D8D8D8;" cellpadding="4" cellspacing="4">
    <thead>
        <tr>
            <th>{{ trans('user.appointments.index.th.code') }}</th>
            <th>{{ trans('user.appointments.index.th.calendar') }}</th>
            <th>{{ trans('user.appointments.index.th.start_time') }}</th>
            <th>{{ trans('user.appointments.index.th.contact') }}</th>
            <th>{{ trans('user.appointments.index.th.service') }}</th>
            <th>{{ trans('user.appointments.index.th.status') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($appointments as $appointment)
    <tr>
        <td style="padding:4px; color:#444;">{{ $appointment->code }}</td>
        <td style="padding:4px; color:#444;">{{ $appointment->date() }}</td>
        <td style="padding:4px; color:#444;">{{ $appointment->time() }}</td>
        <td style="padding:4px; color:#444;">{{ $appointment->contact->firstname }}</td>
        <td style="padding:4px; color:#444;">{{ $appointment->service->name }}</td>
        <td style="padding:4px; color:#444;">{{ $appointment->status }}</td>
    </tr>
    @endforeach
    </tbody>
</table>