{{-- Appointment Table Partial --}}
<table class="table table-hover">
    <thead>
        <tr>
            <th><span class="hidden-md">{!! Icon::asterisk() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.status') }}</span></th>
            <th><span class="hidden-md">{!! Icon::calendar() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.calendar') }}</span></th>
            <th><span class="hidden-md">{!! Icon::time() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.start_time') }}</span></th>
            <th><span class="hidden-md">{!! Icon::time() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.finish_time') }}</span></th>
            <th><span class="hidden-md">{!! Icon::hourglass() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.duration') }}</span></th>
            <th><span class="hidden-md">{!! Icon::tag() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.service') }}</span></th>
            <th><span class="hidden-md">{!! Icon::user() !!}</span>&nbsp;<span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.contact') }}</span></th>
            <th></th>
        </tr>
    </thead>
    <tbody class="searchable">

        @foreach ($appointments as $appointment)
        {!! $appointment->row !!}
        @endforeach
    </tbody>
</table>