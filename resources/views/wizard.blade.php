@extends('app')

@section('content')
<div class="container">
    <div class="row">
        {!! Alert::info('Qué necesitás hacer?') !!}
    </div>
    <div class="row">
            <div class="col-md-offset-2">
                <div class="col-md-5">
                        
                        {!! Panel::normal()->withHeader('<strong>Prestadores</strong> Quiero dar turnos por internet')->withBody(
                            Thumbnail::image('//lorempixel.com/350/150/business/7')->caption('Si <strong>tenés un negocio o sos prestador</strong>, acá podés dar de alta tu comercio y empezar a dar turnos por internet.').
                            Button::success('Soy prestador!')->large()->block()->asLinkTo(route('manager.business.index'))
                        ) !!}

                </div>
                <div class="col-md-5">
    
                    {!! Panel::normal()->withHeader('<strong>Clientes</strong> Quiero pedir turnos por internet')->withBody(
                        Thumbnail::image('//lorempixel.com/350/150/people/1')->caption('Si <strong>querés encontrar un prestador</strong> para reservar sus servicios, acá podés encontrar el que más te gusta y reservar tu turno!.').
                        Button::primary('Soy cliente!')->large()->block()->asLinkTo(route('user.businesses.list'))
                        ) !!}

                </div>
            </div>
    </div>
</div>
@endsection
