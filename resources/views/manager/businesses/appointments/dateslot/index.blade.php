@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('user.appointments.index.title') }}</div>
                    <div class="panel-body">
                        <table class="table table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th><span class="hidden-md">{!! Icon::barcode() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.code') }}</span></th>
                                    <th><span class="hidden-md">{!! Icon::asterisk() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.status') }}</span></th>
                                    <th><span class="hidden-md">{!! Icon::calendar() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.calendar') }}</span></th>
                                    <th><span class="hidden-md">{!! Icon::time() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.start_time') }}</span></th>
                                    <th><span class="hidden-md">{!! Icon::briefcase() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.service') }}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td><code>{{ $appointment->code }}</code></td>
                                    <td>{{ $appointment->status }}</td>
                                    <td>{{ $appointment->start_at->timezone($appointment->tz)->toDateString() }}</td>
                                    <td title="{{ $appointment->tz }}">{{ $appointment->start_at->timezone($appointment->tz)->toTimeString() }}</td>
                                    <td>{{ $appointment->service ? $appointment->service->name : '' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
