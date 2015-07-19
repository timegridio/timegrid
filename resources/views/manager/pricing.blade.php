@extends('app')

@section('css')
@parent
<style>
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
  border-top: 0;
}
.flat .plan li.plan-name {
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

        <p>&nbsp;</p>

  <div class="row flat">
    <div class="col-lg-offset-3 col-md-offset-3 col-xs-offset-1">
            <div class="col-lg-4 col-md-4 col-xs-6">
                <ul class="plan plan1 featured">
                    <li class="plan-name">
                        Free
                    </li>
                    <li class="plan-price">
                        <big><span class="label label-success"><strong>GRATIS</strong></span></big>
                    </li>
                    <li>
                        <strong>200</strong> contactos en agenda
                    </li>
                    <li>
                        <strong>ilimitados</strong> turnos por mes
                    </li>
                    <li>
                        <strong>ilimitadas</strong> alertas por email
                    </li>
                    <li class="plan-action">
                        <a href="#" class="btn btn-danger btn-lg">{!! Icon::cloud_upload() !!}&nbsp;Empezar</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-4 col-xs-6">
                <ul class="plan plan2">
                    <li class="plan-name">
                        Corporativo
                    </li>
                    <li class="plan-price">
                        <strong>USD 10</strong> / mes
                    </li>
                    <li>
                        <strong>1000</strong> contactos en agenda
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
                    <li class="plan-action">
                     <a href="#" class="btn btn-danger btn-lg">{!! Icon::shopping_cart() !!}&nbsp;Contratar</a>
                 </li>
                </ul>
            </div>

    </div> <!-- /offset -->
  </div> <!-- /flat -->
</div> <!-- /container -->
@endsection
