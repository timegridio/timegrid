@extends('emails.'.App::getLocale().'.layout')

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
            {{ $appointment->business->name }}&nbsp;<small style="color:#969696"> via {{trans('app.name')}}</small>
          </td>
        </tr>
        <tr>
          <td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff">
            <br>

<div class="title" style="font-family:Helvetica,Arial, sans-serif;font-size:18px;font-weight:600;color:#374550">{{ $user->name }}, your reservation was canceled:</div>

<div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">

<pre>
----------------------------------------------
 CANCELED APPOINTMENT
----------------------------------------------

Your appointment {{ $appointment->code() }} at {{ $appointment->business->name }} for
{{ $appointment->service->name }} {{ $appointment->time() }} was canceled.

@if($appointment->business->phone && $appointment->business->pref('show_phone'))
For contacting {{ $appointment->business->name }} please call {{ $appointment->business->phone }}
@endif
</pre>
<br>
</div>

          </td>
        </tr>
        <tr>
          <td class="container-padding footer-text" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:16px;color:#aaaaaa;padding-left:24px;padding-right:24px">
          @include('emails.'.App::getLocale().'._footer')
          </td>
        </tr>
      </table>
<!--/600px container -->

    </td>
  </tr>
</table>
<!--/100% background wrapper-->
@endsection
