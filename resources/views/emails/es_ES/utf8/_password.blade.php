@extends('emails.'.App::getLocale().'.layout')

@section('content')
<!-- 100% background wrapper (grey background) -->
<table bgcolor="#F0F0F0" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" bgcolor="#F0F0F0" style="background-color: #F0F0F0;" valign="top">
            <br>
            <!-- 600px container (white background) -->
            <table border="0" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px"
            width="600">
                <tr>
                    <td align="left" class="container-padding header" style=
                    "font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px">
                    {{trans('app.name')}}</td>
                </tr>

                <tr>
                    <td align="left" class="container-padding content" style=
                    "padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff">
                    <br>

                        <div class="title" style=
                        "font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:600;color:#374550">
                            ¿Solicitaste blanquear tu contraseña?
                        </div>
                        <br>


                        <div class="body-text" style=
                        "font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
                        <br>
                            Dirigite a la siguiente dirección para blanquear tu contraseña:<br>
                            {{ url('password/reset/'.$token) }}<br>
                            <br>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td align="left" class="container-padding footer-text" style=
                    "font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:16px;color:#aaaaaa;padding-left:24px;padding-right:24px">
                    @include('emails.'.App::getLocale().'._footer')</td>
                </tr>
            </table>
            <!--/600px container -->
        </td>
    </tr>
</table>
<!--/100% background wrapper-->
@endsection
