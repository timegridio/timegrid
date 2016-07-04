<pre>
----------------------------------------------
Business: {{ $appointment->business->name }}
    Date: {{ $appointment->date }}
    Time: {{ trans_choice('appointments.text.arrive_at', count($arriveAt = $appointment->arriveAt), $arriveAt) }}
    Code: {{ $appointment->code() }}
@if($appointment->business->pref('show_postal_address'))
   Where: {{ $appointment->business->postal_address }}
@endif
@if($appointment->business->pref('show_phone'))
   Phone: {{ $appointment->business->phone }}
@endif
 Service: {{ $appointment->service->name }}
@if($appointment->service->prerequisites)
Important:
{{ $appointment->service->prerequisites }}
@endif
@if ($appointment->comments)
Customer notes for you: {{ $appointment->comments }}
@endif
----------------------------------------------
</pre>