<li class="list-group-item">
{!! Button::normal($appointment->widget()->code(4))->withIcon(Icon::calendar())->asLinkTo(route('manager.business.agenda.index', $appointment->business->id)) !!}
{!! Button::normal($appointment->widget()->dateLabel())->withIcon(Icon::calendar())->asLinkTo(route('manager.business.agenda.index', $appointment->business->id)) !!}
{!! Button::normal($appointment->contact->fullname)->withIcon(Icon::user())->asLinkTo(route('manager.business.contact.show', [$appointment->business->id, $appointment->contact->id])) !!}
{!! Button::normal($appointment->service->name)->withIcon(Icon::tag())->asLinkTo(route('manager.business.service.show', [$appointment->business->id, $appointment->service->id])) !!}
</li>
