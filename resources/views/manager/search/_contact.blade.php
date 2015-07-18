<li class="list-group-item">
@foreach ($contact->businesses as $business)
    {{-- @if (Auth::user()->isOwner($business)) --}}    
        {!! Button::normal($business->name)->withIcon(Icon::home())->asLinkTo(route('manager.business.show', $business->id)) !!}
        {!! Button::normal($contact->fullname)->withIcon(Icon::user())->asLinkTo(route('manager.business.contact.show', [$business->id, $contact->id])) !!}
    {{-- @endif --}}
@endforeach
</li>