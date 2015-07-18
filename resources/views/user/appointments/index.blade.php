@extends('app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.appointments.index.title') }}</div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th><span class="hidden-md">{!! Icon::barcode() !!}</span>    <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.code') }}</span></th>
                    <th><span class="hidden-md">{!! Icon::asterisk() !!}</span>   <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.status') }}</span></th>
                    <th><span class="hidden-md">{!! Icon::calendar() !!}</span>   <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.calendar') }}</span></th>
                    <th><span class="hidden-md">{!! Icon::time() !!}</span>       <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.start_time') }}</span></th>
                    <th><span class="hidden-md">{!! Icon::time() !!}</span>       <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.finish_time') }}</span></th>
                    <th><span class="hidden-md">{!! Icon::hourglass() !!}</span>  <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.duration') }}</span></th>
                    <th><span class="hidden-md">{!! Icon::briefcase() !!}</span><span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.service') }}</span></th>
                    <th><span class="hidden-md">{!! Icon::map_marker() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.business') }}</span></th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                    <tr>
                        <td>{!! Button::normal($appointment->widget()->code())->asLinkTo( route('user.booking.show', [$appointment->business, $appointment]) ) !!}</td>
                        <td>{!! $appointment->widget()->statusLabel() !!}</td>
                        <td>{!! $appointment->widget()->dateLabel() !!}</td>
                        <td title="{{ $appointment->tz }}">{{ $appointment->start_at->timezone($appointment->tz)->toTimeString() }}</td>
                        <td title="{{ $appointment->tz }}">{{ $appointment->finish_at->timezone($appointment->tz)->toTimeString() }}</td>
                        <td>{{ $appointment->duration }}</td>
                        <td>{{ $appointment->service ? $appointment->service->name : '' }}</td>
                        <td>{{ $appointment->business->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel-footer"></div>
    </div>
</div>
@endsection
