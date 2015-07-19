<li class="list-group-item">
{!! Button::normal($appointment->widget()->code(4))->withIcon(Icon::calendar())->asLinkTo(route('manager.business.agenda.index', $appointment->business->id)) !!}
{!! $appointment->widget()->dateLabel() !!}
</li>
