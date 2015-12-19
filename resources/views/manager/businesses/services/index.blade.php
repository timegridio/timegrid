@extends('app')

@section('content')
<div class="container">
    <div class="col-md-6 col-md-offset-3">

        {!! Alert::info(trans('manager.services.index.instructions')) !!}

        <div class="panel panel-default">

            <div class="panel-heading">{{ trans('manager.services.index.title') }}</div>

            <div class="panel-body">

                @foreach ($business->services as $service)
                <p>
                    <div class="btn-group">
                        {!! Button::normal()
                            ->withIcon(Icon::edit())
                            ->asLinkTo(route('manager.business.service.edit', [$business, $service->id]) ) !!}
                        {!! Button::normal($service->name)
                            ->asLinkTo( route('manager.business.service.show', [$business, $service->id]) ) !!}
                    </div>
                </p>
                @endforeach
                
            </div>

            <div class="panel-footer">
                {!! Button::primary(trans('manager.services.btn.create'))
                    ->withIcon(Icon::plus())
                    ->asLinkTo( route('manager.business.service.create', [$business]) )
                    ->block() !!}
            </div>

        </div>
        @if ($business->services()->count())
        {!! Alert::success(trans('manager.services.create.alert.go_to_vacancies')) !!}
        {!! Button::success(trans('manager.services.create.btn.go_to_vacancies'))
            ->withIcon(Icon::time())
            ->asLinkTo(route('manager.business.vacancy.create', $business))
            ->large()
            ->block() !!}
        @endif
    </div>
</div>
@endsection
