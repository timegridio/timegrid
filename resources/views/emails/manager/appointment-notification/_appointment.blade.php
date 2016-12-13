<pre>
----------------------------------------------
{{ trans('emails.text.business') }}: {{ $appointment->business->name }}
    {{ trans('emails.text.date') }}: {{ $appointment->date }}
    {{ trans('emails.text.time') }}: {{ trans_choice('appointments.text.arrive_at', count($arriveAt = $appointment->arriveAt), $arriveAt) }}
    {{ trans('emails.text.code') }}: {{ $appointment->code() }}
@if($appointment->business->pref('show_postal_address'))
   {{ trans('emails.text.where') }}: {{ $appointment->business->postal_address }}
@endif
@if($appointment->business->pref('show_phone'))
   {{ trans('emails.text.phone') }}: {{ $appointment->business->phone }}
@endif
 {{ trans('emails.text.service') }}: {{ $appointment->service->name }}
@if($appointment->service->prerequisites)
{{ trans('emails.text.important') }}:
{{ $appointment->service->prerequisites }}
@endif
@if ($appointment->comments)
{{ trans('emails.text.customer_notes') }}: {{ $appointment->comments }}
@endif
----------------------------------------------
</pre>