<pre>
----------------------------------------------
Business: {{ $appointment->business->name }}
    Date: {{ $appointment->date }}
    Code: {{ $appointment->code() }}
@if($appointment->business->pref('show_phone'))
   Phone: {{ $appointment->business->phone }}
@endif
----------------------------------------------
</pre>