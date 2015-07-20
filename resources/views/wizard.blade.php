@extends('app')

@section('content')
<div class="container">
    <div class="row">
        {!! Alert::info(trans('wizard.alert')) !!}
    </div>
    <div class="row">
            <div class="col-md-offset-2">
                <div class="col-md-5">
                        
                        {!! Panel::normal()->withHeader(trans('wizard.business.header'))->withBody(
                            Thumbnail::image('//lorempixel.com/350/150/business/7')->caption(trans('wizard.business.caption')).
                            Button::success(trans('wizard.business.btn'))->large()->block()->asLinkTo(route('wizard.pricing'))
                        ) !!}

                </div>
                <div class="col-md-5">
    
                    {!! Panel::normal()->withHeader(trans('wizard.user.header'))->withBody(
                        Thumbnail::image('//lorempixel.com/350/150/people/1')->caption(trans('wizard.user.caption')).
                        Button::primary(trans('wizard.user.btn'))->large()->block()->asLinkTo(route('user.businesses.list'))
                        ) !!}

                </div>
            </div>
    </div>
</div>
@endsection

@section('footer_scripts')
@parent
{!! TidioChat::js() !!}
@endsection