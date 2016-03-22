@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-heading">
                {{ trans('user.businesses.index.title') }}
            </div>

            <div class="panel-body">
                @if (!$businesses->isEmpty())
                    @foreach ($businesses as $business)
                        @include('user.businesses._row', ['business' => $business])
                    @endforeach
                @else
                    {{ trans('user.businesses.list.no_businesses') }}
                @endif
            </div>

            <div class="panel-footer">
                @if($user->hasBusiness())
                    {!! Button::normal(trans('user.businesses.index.btn.manage'))->asLinkTo( route('manager.business.index') ) !!}
                @else
                    {!! Button::primary(trans('user.businesses.index.btn.create'))->asLinkTo( route('manager.business.register') ) !!}
                @endif
            </div>

        </div>
    </div>
</div>
@endsection