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
                            <th>{{ trans('manager.services.index.th.name') }}</th>
                            <th>{{ trans('manager.services.index.th.slug') }}</th>
                        </tr>
                    @foreach ($services as $service)
                        <tr>
                            <td title="{{ $service->description }}">
                            <div class="btn-group">
                                {!! Button::normal()->withIcon(Icon::edit())->asLinkTo( route('manager.business.service.edit', [$business->id, $service->id]) ) !!}
                                {!! Button::normal($service->name)->asLinkTo( route('manager.business.service.show', [$business->id, $service->id]) ) !!}
                            </div>
                            </td>
                            <td>{{ $service->slug }}</td>
                        </tr>
                    @endforeach
                    </table>

                    <div class="panel-footer">
                        {!! Button::primary(trans('manager.services.btn.create'))->withIcon(Icon::plus())->asLinkTo( route('manager.business.service.create', [$business->id]) )->block() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
