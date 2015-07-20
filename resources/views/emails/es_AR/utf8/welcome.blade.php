@extends('emails.'.App::getLocale() . '.layout')

@section('content')
<!-- 100% background wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
  <tr>
    <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">

      <br>

      <!-- 600px container (white background) -->
      <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px">
        <tr>
          <td class="container-padding header" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px">
            {{trans('app.name')}}
          </td>
        </tr>
        <tr>
          <td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff">
            <br>
<div class="title" style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:600;color:#374550">Bienvenido a {{trans('app.name')}}</div>
<br>

<div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
  La secretaria de turnos online. Inteligente.
  <br><br>
</div>

<div class="hr" style="height:1px;border-bottom:1px solid #cccccc">&nbsp;</div>
<br>

<!-- example: two columns (simple) -->

<!--[if mso]>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="50%" valign="top"><![endif]-->

    <table width="264" border="0" cellpadding="0" cellspacing="0" align="left" class="force-row">
      <tr>
        <td class="col" valign="top" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333;width:100%">
          <strong>¿Quienes somos?</strong>
          <br><br>
          {{trans('app.name')}} es la central de turnos que se administra sóla. Acabás de registrarte y por eso queremos darte la bienvenida.
          <br><br>
        </td>
      </tr>
    </table>

    <!--[if mso]></td><td width="50%" valign="top"><![endif]-->

    <table width="264" border="0" cellpadding="0" cellspacing="0" align="right" class="force-row">
      <tr>
        <td class="col" valign="top" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333;width:100%">
        <strong>¿Para qué sirve?</strong>
        <br><br>
        Tanto si sos prestador de servicios o cliente, <strong>{{trans('app.name')}}</strong> te ayudará para que esto de los <strong>turnos</strong> sea casi un juego.
        <br><br>
        </td>
      </tr>
    </table>

<!--[if mso]></td></tr></table><![endif]-->


<!--/ end example -->

<div class="hr" style="height:1px;border-bottom:1px solid #cccccc;clear: both;">&nbsp;</div>
<br>

<div class="subtitle" style="font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:600;color:#2469A0">
  ¿Preguntas?
</div>

<div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
  <ol>
    <li>
      <strong>¿Es gratis?</strong><br>
      <strong>Sí!</strong> Pedir y dar turnos es gratis. Si sos prestador y necesitás más potencia también tenemos un plan especial para tu negocio.<br>
    </li>
    <li>
      <strong>¿Puedo empezar a pedir turnos?</strong><br>
      <strong>Sí!</strong> Pedir turnos es muy fácil. Buscás el prestador que te guste en nuestro directorio, lo hacés favorito, y ya podés pedirle turnos!<br>
    </li>
    <li>
      <strong>¿Tengo que registrarme de nuevo por cada prestador?</strong><br>
      <strong>No!</strong> Ya te registraste! El mismo usuario te servirá para todos nuestros prestadores afiliados.<br>
    </li>
    <li>
      <strong>¿Alguna recomendación?</strong><br>
      <strong>Sí!</strong> Los prestadores hacen lo mejor por darte el mejor servicio. Reservar y anular turnos ahora es bien fácil. Respetá los turnos y si no podés asistir, cancelalo a tiempo.<br>
    </li>
  </ol>

  Disfrutá tu tiempo ahorrado con un paseo al parque! :)
</div>

<br>
          </td>
        </tr>
        <tr>
          <td class="container-padding footer-text" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:16px;color:#aaaaaa;padding-left:24px;padding-right:24px">
            @include('emails._footer')
          </td>
        </tr>
      </table>
<!--/600px container -->


    </td>
  </tr>
</table>
<!--/100% background wrapper-->
@endsection