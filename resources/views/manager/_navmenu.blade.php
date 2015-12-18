@if(($business = Session::get('selected.business')) && auth()->user()->isOwner($business))

    <li>{!! Button::withIcon(Icon::calendar())->withAttributes(['id' => 'btnAgenda', 'title' => trans('manager.business.btn.tooltip.agenda')])->normal()->asLinkTo( route('manager.business.agenda.index', $business) ) !!}</li>
    <li>{!! Button::withIcon(Icon::user())->withAttributes(['id' => 'btnContacts', 'title' => trans('manager.business.btn.tooltip.contacts')])->normal()->asLinkTo( route('manager.business.contact.index', $business) ) !!}</li>
    <li>{!! Button::withIcon(Icon::time())->normal()->withAttributes(['id' => 'btnVacancies', 'title' => trans('manager.business.btn.tooltip.vacancies')])->asLinkTo( route('manager.business.vacancy.create', $business) ) !!}</li>
    <li>{!! Button::withIcon(Icon::tag())->normal()->withAttributes(['id' => 'btnServices', 'title' => trans('manager.business.btn.tooltip.services')])->asLinkTo( route('manager.business.service.index', $business) ) !!}</li>

    <li id="navHome"><a href="{{ route('manager.business.show', $business->slug) }}">{!! Icon::home() !!} {{ $business->name }}</a></li>

    {!! Form::open(['method' => 'post', 'url' => route('manager.search', $business), 'class' => 'navbar-form navbar-left', 'role' => 'search']) !!}
    <div class="form-group">
        <input id="search" name="criteria" type="text" class="form-control" placeholder="{{trans('app.search.placeholder')}}">
    </div>
    {!! Form::close() !!}
@endif
