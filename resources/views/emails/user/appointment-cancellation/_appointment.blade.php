<pre>
----------------------------------------------
{{ trans('emails.text.business') }}: {{ $appointment->business->name }}
    {{ trans('emails.text.date') }}: {{ $appointment->date }}
    {{ trans('emails.text.code') }}: {{ $appointment->code() }}
@if($appointment->business->pref('show_phone'))
   {{ trans('emails.text.phone') }}: {{ $appointment->business->phone }}
@endif
----------------------------------------------
</pre>