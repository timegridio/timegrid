@extends('app')

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
                        Individual
                    </li>
                    <li class="plan-price">
                        <big><span class="label label-success"><strong>GRATIS</strong></span></big>
                    </li>
                    <li id="p1_contacts">
                        <strong>200</strong> contactos en agenda
                    </li>
                    <li id="p1_services">
                        <strong>3</strong> servicios registrables
                    </li>
                    <li id="p1_appointments">
                        <strong>ilimitados</strong> turnos por mes
                    </li>
                    <li id="p1_alerts_email">
                        <strong>ilimitadas</strong> alertas por email
                    </li>
                    <li class="plan-action">
                        <a href="{{ route('manager.business.create') }}" class="btn btn-danger btn-lg">{!! Icon::cloud_upload() !!}&nbsp;Empezar</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-4 col-xs-6">
                <ul class="plan plan2" id="plan2">
                    <li class="plan-name">
                        Corporativo
                    </li>
                    <li class="plan-price">
                        <strong>&euro; 10</strong> / mes
                    </li>
                    <li>
                        <strong>2000</strong> contactos en agenda
                    </li>
                    <li>
                        <strong>ilimitados</strong> servicios registrables
                    </li>
                    <li>
                        <strong>ilimitados</strong> turnos por mes
                    </li>
                    <li>
                        <strong>ilimitadas</strong> alertas por email
                    </li>
                    <li>
                        <strong>1000</strong> alertas por SMS por mes
                    </li>
                    <li>
                        <strong>reportes</strong> gráficos
                    </li>
                    <li class="plan-action">
                     <a href="{{ route('manager.business.create') }}" class="btn btn-danger btn-lg">{!! Icon::shopping_cart() !!}&nbsp;Contratar</a>
                 </li>
                </ul>
            </div>


    </div> <!-- /offset -->
  </div> <!-- /flat -->

            <div class="row well" style="background-color:#fff">

              <ul class="list-inline">
                <li><img src="http://megaicons.net/static/img/icons_sizes/19/129/256/paypal-icon.png" alt="cobrar con PayPal" height="60"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_c1.gif" alt="Saldo CuentaDigital" width="108" height="25"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_c11.gif" alt="VoucherDigital" width="68" height="25"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_c20.gif" alt="PagoFacil Pago Facil" width="30" height="25"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_c27.gif" alt="RapiPago Rapi Pago" width="68" height="25"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_c56.gif" alt="CobroExpress" width="48" height="25"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_c63.gif" alt="Ripsa" width="44" height="25"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_c68.png" alt="Link RedLink PagosLink LinkPagos" width="26" height="25"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_c76.gif" alt="PagoDirecto Pago Directo Debito Automatico" width="43" height="25"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r2_c36.gif" alt="Bapro BaproPagos" width="68" height="20"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r2_c44.gif" alt="ProvinciaPagos Provincia Pagos" width="65" height="21"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_formo.gif" alt="FormoPagos" height="25"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_pagolisto.gif" alt="Pagolisto" height="31"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_pampa.gif" alt="PampaPagos" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_chubut.gif" alt="ChubutPagos" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r1_coope.gif" alt="Cooperativa Obrera" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/logo_r8_c40.gif" alt="Transferencia Bancaria Local" width="76" height="25"></li>
                <li><img src="http://cuentadigital.com/img/logos/visa.png" alt="cobrar con VISA" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/mastercard.png" alt="cobrar con MASTERCARD" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/argencard.png" alt="cobrar con ARGENCARD" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/amex.png" alt="cobrar con American Express AMEX" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/tarjetanaranja.png" alt="cobrar con tarjeta NARANJA" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/shopping.png" alt="cobrar con TARJETA SHOPPING" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/cencosud.png" alt="cobrar con TARJETA CENCOSUD" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/nativa.png" alt="cobrar con NATIVA" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/tarjetamas.png" alt="cobrar con TARJETA MAS" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/diners.png" alt="cobrar con DINERS" height="30"></li>
                <li><img src="http://cuentadigital.com/img/logos/cordobesa.png" alt="cobrar con tarjeta CORDOBESA" height="30"></li>
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
  duration: 10000,
  delay: 10000,
  steps: [
  {
    element: "#plan1",
    title: "Si recién empezás",
    content: "El plan ideal para prestadores con turnos dispersos"
  },
  {
    element: "#p1_contacts",
    title: "Contactos",
    content: "Te dejamos registrar hasta 200 contactos en tu agenda. Así tenés organizada tu cartera de clientes con todos los datos que necesitás. Necesitás más?"
  },
  {
    element: "#p1_services",
    title: "Servicios",
    content: "Podés registrar hasta 3 servicios que des. Tus clientes van a poder reservarte por alguno de ellos, tener pre-indicaciones y ahorrar tiempo el día de la visita!"
  },
  {
    element: "#p1_appointments",
    title: "Turnos",
    content: "No tengas miedo: entregá reservá los turnos que necesites. Tu agenda estará siempre organizada y al día. Tu tiempo vale!"
  },
  {
    element: "#plan2",
    title: "Negocios",
    content: "El plan que necesita tu comercio para administrar tanta demanda!"
  }
]});

// Initialize the tour
tour.init();

// Start the tour
tour.start();

});
</script>
@endsection