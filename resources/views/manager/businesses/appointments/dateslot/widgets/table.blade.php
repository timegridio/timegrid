<table class="table table-hover">
  <thead>
    <tr>
      <th><span class="hidden-md">{!! Icon::asterisk() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.status') }}</span></th>
      <th><span class="hidden-md">{!! Icon::barcode() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.code') }}</span></th>
      <th><span class="hidden-md">{!! Icon::user() !!}</span> <span class="">{{ trans('user.appointments.index.th.contact') }}</span></th>
      <th><span class="hidden-md">{!! Icon::calendar() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.calendar') }}</span></th>
      <th><span class="hidden-md">{!! Icon::time() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.start_time') }}</span></th>
      <th><span class="hidden-md">{!! Icon::briefcase() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.service') }}</span></th>
      <th><span class="hidden-md">{!! Icon::map_marker() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.business') }}</span></th>
      <th><span class="hidden-md">{!! Icon::hourglass() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.remaining') }}</span></th>
      <th></th>
    </tr>
  </thead>
  <tbody class="searchable">
    @foreach ($appointments as $appointment)
      {!! Widget::AppointmentsTableRow(['appointment' => $appointment->getPresenter(), 'user' => auth()->user()]) !!}
    @endforeach
  </tbody>
</table>