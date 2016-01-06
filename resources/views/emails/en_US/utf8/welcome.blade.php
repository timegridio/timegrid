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
<div class="title" style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:600;color:#374550">{{ $user->name }}, welcome to {{trans('app.name')}}</div>
<br>

<div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
  The online reservation app for successful professionals.
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
          <strong>Who are we?</strong>
          <br><br>
          <strong>{{trans('app.name')}}</strong> is the online reservation app for businesses. You have just registered, so we want to give you the welcome.
          <br><br>
        </td>
      </tr>
    </table>

    <!--[if mso]></td><td width="50%" valign="top"><![endif]-->

    <table width="264" border="0" cellpadding="0" cellspacing="0" align="right" class="force-row">
      <tr>
        <td class="col" valign="top" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333;width:100%">
        <strong>What is this for?</strong>
        <br><br>
        With  <strong>{{trans('app.name')}}</strong> you will be able to easily make online service reservations or provide the appointments if you run a business.
        <br><br>
        </td>
      </tr>
    </table>

<!--[if mso]></td></tr></table><![endif]-->


<!--/ end example -->

<div class="hr" style="height:1px;border-bottom:1px solid #cccccc;clear: both;">&nbsp;</div>
<br>

<div class="subtitle" style="font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:600;color:#2469A0">
  Questions?
</div>

<div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
  <ol>
    <li>
      <strong>Is it free?</strong><br>
      <strong>Yes!</strong> Taking and giving reservations is free. We also have featured plans if your business needs even more power.<br>
      <br>
    </li>
    <li>
      <strong>May I begin taking reservations?</strong><br>
      <strong>Yes!</strong> It's pretty easy!<br>
      <br>
    </li>
    <li>
      <strong>Do I need to signup for every business?</strong><br>
      <strong>No!</strong> Once you are registered, you may use the same credentials for any business.<br>
      <br>
    </li>
    <li>
      <strong>Any recommendation?</strong><br>
      <strong>Yes!</strong> Business do an important effort to give you the best service possible. Be on-time and respect your reservations. Remember you can always annulate in advance ant thats the best choice when you can't assist.<br>
      <br>
    </li>
  </ol>

  Now, enjoy! :)<br><br>

  <a href="{!! route('home') !!}" style="color:#aaaaaa">Go to timegrid.io</a><br>
</div>

<br>
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