@extends('layouts.app')

@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/bootstrap-tour.min.css') }}">
<style>
@import url(http://fonts.googleapis.com/css?family=Lato);
body{
  background-color: #f0f0f0;
}
.flat .plan {
  border-radius: 6px;
  list-style: none;
  padding: 0 0 20px;
  margin: 0 0 15px;
  background: #fff;
  text-align: center;
}
.flat .plan li {
  padding: 10px 15px;
  color: #888;
  border-top: 1px solid #f5f5f5;
  -webkit-transition: 300ms;
  transition: 300ms;
}
.flat .plan li.plan-price {
  font-family: 'Lato', sans-serif;
  font-size: 2em;
  border-top: 0;
}
.flat .plan li.plan-hint {
  font-family: 'Lato', sans-serif;
  font-size: 1em;
  border-top: 0;
  color: #9a9a9a;
  background-color: #fafafa;
  border: 0;
  border-top: 1px dashed #9a9a9a;
  border-bottom: 1px dashed #9a9a9a;
}
.flat .plan li.plan-name {
  font-family: 'Lato', sans-serif;
  border-radius: 6px 6px 0 0;
  padding: 15px;
  font-size: 24px;
  line-height: 24px;
  color: #fff;
  background: #e74c3c;
  margin-bottom: 30px;
  border-top: 0;
}
.flat .plan li > strong {
  color: #e74c3c;
}
.flat .plan li.plan-action {
  margin-top: 10px;
  border-top: 0;
}
.flat .plan.featured :hover {
  -webkit-transform: scale(1.05);
  -ms-transform: scale(1.05);
  transform: scale(1.05);
}
.plan-action .btn{
  font-family: 'Lato', sans-serif;
  font-size: 1.5em;
}
.plan-action .btn:hover{
  background-color: #5CB85C;
  border: 1px solid #5CB85C;
}
.flat .plan.featured li.plan-name {
  background: #367FA9;
}
.flat .plan.featured:hover li.plan-name {
  background: #5CB85C;
}
.flat .plan:hover li.plan-name {
  background: #EEE232;
}
#footer {
  margin-top: 100px;
  padding-bottom: 30px;
}
</style>
@endsection

@section('content')
<div class="container">

  <div class="row flat">
    <div class="col-lg-offset-3 col-md-offset-3 col-xs-offset-1">
            <div class="col-lg-4 col-md-4 col-xs-6">
                <ul class="plan plan1 featured" id="plan1">
                    <li class="plan-name">
                        {{trans('pricing.plan.free.name')}}
                    </li>
                    <li class="plan-hint">
                        {{trans('pricing.plan.free.hint')}}
                    </li>
                    <li class="plan-price">
                        <big><span class="label label-success"><strong>{{trans('pricing.free')}}</strong></span></big>
                    </li>
                    <li id="p1_contacts">
                        <strong>{{trans_choice('pricing.unlimited',1)}}</strong> {{trans('pricing.plan.feature.contacts')}}
                    </li>
                    <li id="p1_services">
                        <strong>3</strong> {{trans('pricing.plan.feature.services')}}
                    </li>
                    <li id="p1_appointments">
                        <strong>{{trans_choice('pricing.unlimited',1)}}</strong> {{trans('pricing.plan.feature.appointments')}}
                    </li>
                    <li id="p1_alerts_email">
                        <strong>{{trans_choice('pricing.unlimited',2)}}</strong> {{trans('pricing.plan.feature.email_alerts')}}
                    </li>
                    <li class="plan-action">
                        <a href="{{ route('manager.business.register', ['plan' => 'free']) }}" class="btn btn-danger btn-lg">{!! Icon::cloud_upload() !!}&nbsp;{{trans('pricing.plan.free.submit')}}</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-4 col-xs-6">
                <ul class="plan plan2" id="plan2">
                    <li class="plan-name">
                        {{trans('pricing.plan.starter.name')}}
                    </li>
                    <li class="plan-hint">
                        {{trans('pricing.plan.starter.hint')}}
                    </li>
                    <li class="plan-price">
                        {{-- Important to use unescaped for currency as might have html entities --}}
                        <strong>{!! trans('pricing.currency_price') !!}</strong> / {{trans('pricing.month')}}
                    </li>
                    <li>
                        <strong>{{trans_choice('pricing.unlimited',1)}}</strong> {{trans('pricing.plan.feature.contacts')}}
                    </li>
                    <li>
                        <strong>{{trans_choice('pricing.unlimited',1)}}</strong> {{trans('pricing.plan.feature.services')}}
                    </li>
                    <li>
                        <strong>{{trans_choice('pricing.unlimited',1)}}</strong> {{trans('pricing.plan.feature.appointments')}}
                    </li>
                    <li>
                        <strong>{{trans_choice('pricing.unlimited',2)}}</strong> {{trans('pricing.plan.feature.email_alerts')}}
                    </li>
                    <li>
                        {!! Icon::signal() !!}&nbsp;&nbsp;{{trans('pricing.plan.feature.reports')}}
                    </li>
                    <li class="plan-action">
                     <a href="{{ route('manager.business.register', ['plan' => 'starter']) }}" class="btn btn-danger btn-lg">{!! Icon::shopping_cart() !!}&nbsp;{{trans('pricing.plan.starter.submit')}}</a>
                 </li>
                </ul>
            </div>


    </div> <!-- /offset -->
  </div> <!-- /flat -->

            <div class="row well" style="background-color:#fff" id="payment">

              <ul class="list-inline">
                <li><img src="{!! asset('img/payment/logos/paypal-logo.png') !!}" alt="Cobrar con PayPal" height="60"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_c1.gif') !!}" alt="Saldo CuentaDigital" width="108" height="25"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_c11.gif') !!}" alt="VoucherDigital" width="68" height="25"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_c20.gif') !!}" alt="PagoFacil Pago Facil" width="30" height="25"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_c27.gif') !!}" alt="RapiPago Rapi Pago" width="68" height="25"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_c56.gif') !!}" alt="CobroExpress" width="48" height="25"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_c63.gif') !!}" alt="Ripsa" width="44" height="25"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_c68.png') !!}" alt="Link RedLink PagosLink LinkPagos" width="26" height="25"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_c76.gif') !!}" alt="PagoDirecto Pago Directo Debito Automatico" width="43" height="25"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r2_c36.gif') !!}" alt="Bapro BaproPagos" width="68" height="20"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r2_c44.gif') !!}" alt="ProvinciaPagos Provincia Pagos" width="65" height="21"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_formo.gif') !!}" alt="FormoPagos" height="25"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_pagolisto.gif') !!}" alt="Pagolisto" height="31"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_pampa.gif') !!}" alt="PampaPagos" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_chubut.gif') !!}" alt="ChubutPagos" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r1_coope.gif') !!}" alt="Cooperativa Obrera" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/logo_r8_c40.gif') !!}" alt="Transferencia Bancaria Local" width="76" height="25"></li>
                <li><img src="{!! asset('img/payment/logos/visa.png') !!}" alt="cobrar con VISA" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/mastercard.png') !!}" alt="cobrar con MASTERCARD" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/argencard.png') !!}" alt="cobrar con ARGENCARD" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/amex.png') !!}" alt="cobrar con American Express AMEX" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/tarjetanaranja.png') !!}" alt="cobrar con tarjeta NARANJA" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/shopping.png') !!}" alt="cobrar con TARJETA SHOPPING" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/cencosud.png') !!}" alt="cobrar con TARJETA CENCOSUD" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/nativa.png') !!}" alt="cobrar con NATIVA" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/tarjetamas.png') !!}" alt="cobrar con TARJETA MAS" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/diners.png') !!}" alt="cobrar con DINERS" height="30"></li>
                <li><img src="{!! asset('img/payment/logos/cordobesa.png') !!}" alt="cobrar con tarjeta CORDOBESA" height="30"></li>
              </ul>
            </div>

</div> <!-- /container -->
@endsection

@section('footer_scripts')
<script src="{{ asset('js/bootstrap-tour.min.js') }}"></script>
@parent
<script>
$(document).ready(function(){

// Instance the tour
var tour = new Tour({
  duration: 6500,
  delay: 1000,
  steps: [
  {
    element: "#plan1",
    title: "{{trans('tour.pricing.step1.title')}}",
    content: "{{trans('tour.pricing.step1.content')}}",
    placement: "left"
  },
  {
    element: "#p1_contacts",
    title: "{{trans('tour.pricing.step2.title')}}",
    content: "{{trans('tour.pricing.step2.content')}}"
  },
  {
    element: "#p1_services",
    title: "{{trans('tour.pricing.step3.title')}}",
    content: "{{trans('tour.pricing.step3.content')}}"
  },
  {
    element: "#p1_appointments",
    title: "{{trans('tour.pricing.step4.title')}}",
    content: "{{trans('tour.pricing.step4.content')}}"
  },
  {
    element: "#plan2",
    title: "{{trans('tour.pricing.step5.title')}}",
    content: "{{trans('tour.pricing.step5.content')}}"
  },
  {
    element: "#payment",
    title: "{{trans('tour.pricing.step6.title')}}",
    content: "{{trans('tour.pricing.step6.content')}}",
    placement: "top"
  }
]});

// Initialize the tour
tour.init();

// Start the tour
tour.start();

});
</script>
@endsection