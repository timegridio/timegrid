<!-- Sidebar Menu -->
<ul class="sidebar-menu">

    <li class="header">{{ $business->name }}</li>
    <!-- Optionally, you can add icons to the links -->
    <li class="{{{ $route == 'manager.business.show' ? 'active' : '' }}}" title="{{ $business->name }}" >
        <a href="{{ route('manager.business.show', $business->slug) }}">
            <i class="fa fa-home"></i>
            <span>{{ $business->name }}</span>
        </a>
    </li>

    <li class="{{{ $route == 'manager.addressbook.index' ? 'active' : '' }}}" title="{{ trans('nav.manager.left.addressbook') }}" >
        <a href="{{ route('manager.addressbook.index', $business) }}">
            <i class="fa fa-users"></i>
            <span>{{ trans('nav.manager.left.addressbook') }}</span>
        </a>
    </li>

    <li class="{{{ $route == 'manager.business.agenda.index' ? 'active' : '' }}}" title="{{ trans('nav.manager.left.agenda') }}" >
        <a href="{{ route('manager.business.agenda.index', $business) }}">
            <i class="fa fa-calendar-check-o"></i>
            <span>{{ trans('nav.manager.left.agenda') }}</span>
        </a>
    </li>

    <li class="{{{ $route == 'manager.business.agenda.calendar' ? 'active' : '' }}}" title="{{ trans('nav.manager.left.calendar') }}" >
        <a href="{{ route('manager.business.agenda.calendar', $business) }}">
            <i class="fa fa-calendar"></i>
            <span>{{ trans('nav.manager.left.calendar') }}</span>
        </a>
    </li>

    <li class="{{{ $route == 'manager.business.humanresource.index' ? 'active' : '' }}}" title="{{ trans('nav.manager.left.staff') }}" >
        <a href="{{ route('manager.business.humanresource.index', $business) }}">
            <i class="fa fa-user-md"></i>
            <span>{{ trans('nav.manager.left.staff') }}</span>
        </a>
    </li>

    <li class="{{{ $route == 'manager.business.service.index' ? 'active' : '' }}}" title="{{ trans('nav.manager.left.services') }}" >
        <a href="{{ route('manager.business.service.index', $business) }}">
            <i class="fa fa-tags"></i>
            <span>{{ trans('nav.manager.left.services') }}</span>
        </a>
    </li>

    <li class="{{{ $route == 'manager.business.vacancy.create' ? 'active' : '' }}}" title="{{ trans('nav.manager.left.availability') }}" >
        <a href="{{ route('manager.business.vacancy.create', $business) }}">
            <i class="fa fa-calendar-o"></i>
            <span>{{ trans('nav.manager.left.availability') }}</span>
        </a>
    </li>

    <!-- Language Switcher -->
    @include('manager._sidebar-menu-i18n')

</ul>
<!-- /.sidebar-menu -->