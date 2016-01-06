<li class="list-group-item">
    <div class="btn-group">
        {!! Button::normal($appointment->business->name)->large()->withIcon(Icon::home())->asLinkTo(route('manager.business.show', $appointment->business)) !!}
        {!! Button::normal($appointment->date)->large()->withIcon(Icon::calendar())->asLinkTo(route('manager.business.agenda.index', $appointment->business)) !!}
        {!! Button::normal($appointment->contact->firstname.' '.$appointment->contact->lastname)->large()->withIcon(Icon::user())->asLinkTo(route('manager.addressbook.show', [$appointment->business, $appointment->contact->id])) !!}
        {!! Button::normal($appointment->service->name)->large()->withIcon(Icon::tag())->asLinkTo(route('manager.business.service.show', [$appointment->business, $appointment->service->id])) !!}
    </div>
</li>
