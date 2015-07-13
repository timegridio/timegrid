@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">

                <div class="panel-heading">{{ trans('manager.services.index.title') }}</div>

                <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
                            <th></th>
                            <th>{{ trans('manager.services.index.th.name') }}</th>
                            <th>{{ trans('manager.services.index.th.slug') }}</th>
                            <th>{{ trans('manager.services.index.th.duration') }}</th>
                        </tr>
                    @foreach ($services as $service)
                        <tr>
                            <td>{!! Button::normal()->withIcon(Icon::edit())->asLinkTo( route('manager.business.service.edit', [$business->id, $service->id]) ) !!}</td>
                            <td title="{{ $service->description }}">{!! Button::normal($service->name)->asLinkTo( route('manager.business.service.show', [$business->id, $service->id]) ) !!}</td>
                            <td>{{ $service->slug }}</td>
                            <td>{{ $service->duration }}</td>
                        </tr>
                    @endforeach
                    </table>

                    <div class="panel-footer">
                        {!! Button::normal()->withIcon(Icon::plus())->asLinkTo( route('manager.business.service.create', [$business->id]) ) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
