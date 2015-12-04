<li class="list-group-item">
    <div class="btn-group">
        {!! Button::normal($appointment->business->name)->large()->withIcon(Icon::home())->asLinkTo(route('manager.business.show', $appointment->business->id)) !!}
        {!! Button::normal($appointment->date)->large()->withIcon(Icon::calendar())->asLinkTo(route('manager.business.agenda.index', $appointment->business->id)) !!}
        {!! Button::normal($appointment->contact->fullname)->large()->withIcon(Icon::user())->asLinkTo(route('manager.business.contact.show', [$appointment->business->id, $appointment->contact->id])) !!}
        {!! Button::normal($appointment->service->name)->large()->withIcon(Icon::tag())->asLinkTo(route('manager.business.service.show', [$appointment->business->id, $appointment->service->id])) !!}
    </div>
</li>
