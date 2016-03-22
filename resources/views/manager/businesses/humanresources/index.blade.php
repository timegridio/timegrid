@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-6 col-md-offset-3">

        {!! Alert::info(trans('manager.humanresource.index.instructions')) !!}

        <div class="panel panel-default">

            <div class="panel-heading">{{ trans('manager.humanresource.index.title') }}</div>

            <div class="panel-body">

                @foreach ($business->humanresources as $humanresource)
                <p>
                    <div class="btn-group">
                        {!! Button::normal()
                            ->withIcon(Icon::edit())
                            ->asLinkTo(route('manager.business.humanresource.edit', [$business, $humanresource->id]) ) !!}

                        {!! Button::normal($humanresource->name)
                            ->asLinkTo( route('manager.business.humanresource.show', [$business, $humanresource->id]) ) !!}
                    </div>
                </p>
                @endforeach
                
            </div>

            <div class="panel-footer">
                {!! Button::primary(trans('manager.humanresource.btn.create'))
                    ->withIcon(Icon::plus())
                    ->asLinkTo( route('manager.business.humanresource.create', [$business]) )
                    ->block() !!}
            </div>

        </div>

    </div>
</div>
@endsection
