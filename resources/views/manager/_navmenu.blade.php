@if($business && $user->isOwner($business->id))

    <li id="btnAgenda" title="{{ trans('manager.business.btn.tooltip.agenda') }}" >
        <a href="{{ route('manager.business.agenda.index', $business) }}">{!! Icon::calendar() !!}</a>
    </li>

    <li id="btnContacts" title="{{ trans('manager.business.btn.tooltip.contacts') }}" >
        <a href="{{ route('manager.addressbook.index', $business) }}">{!! Icon::user() !!}</a>
    </li>

    <li id="btnVacancies" title="{{ trans('manager.business.btn.tooltip.vacancies') }}" >
        <a href="{{ route('manager.business.vacancy.create', $business) }}">{!! Icon::time() !!}</a>
    </li>

    <li id="btnServices" title="{{ trans('manager.business.btn.tooltip.services') }}" >
        <a href="{{ route('manager.business.service.index', $business) }}">{!! Icon::tag() !!}</a>
    </li>

    <li id="btnServices" title="{{ trans('manager.business.btn.tooltip.humanresources') }}" >
        <a href="{{ route('manager.business.humanresource.index', $business) }}">{!! Icon::education() !!}</a>
    </li>

    <li id="navHome">
        <a href="{{ route('manager.business.show', $business->slug) }}">{!! Icon::home() !!} {{ $business->name }}</a>
    </li>

    {!! Form::open(['method' => 'post', 'url' => route('manager.search', $business), 'class' => 'navbar-form navbar-left', 'role' => 'search']) !!}
    <div class="form-group">
        <input id="search" name="criteria" type="text" class="form-control" placeholder="{{trans('app.search.placeholder')}}">
    </div>
    {!! Form::close() !!}
@endif
