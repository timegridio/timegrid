<!-- Sidebar Menu -->
<ul class="sidebar-menu">

    <li class="header">{{ route('guest.business.home', $business->slug) }}</li>

    {{-- Configuration --}}
    <li class="treeview">
        <a href="#"><i class="fa fa-home"></i> <span>{{ $business->name }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('manager.business.preferences', $business) }}"><i class="fa fa-cogs"></i><span>{{ trans('nav.manager.left.preferences') }}</span></a></li>
            <li><a href="{{ route('manager.business.edit', $business) }}"><i class="fa fa-pencil-square-o"></i><span>{{ trans('nav.manager.left.edit') }}</span></a></li>
            <li><a href="{{ route('manager.business.vacancy.show', $business) }}"><i class="fa fa-calendar"></i><span>{{ trans('nav.manager.left.availability') }}</span></a></li>
            <li><a href="{{ route('manager.business.notifications.show', $business) }}"><i class="fa fa-bullhorn"></i><span>{{ trans('nav.manager.left.notifications') }}</span></a></li>
        </ul>
    </li>
    {{-- Language Switcher Dropdown --}}

    <!-- Optionally, you can add icons to the links -->
    <li class="{{{ $route == 'manager.business.show' ? 'active' : '' }}}" title="{{ trans('nav.manager.left.dashboard') }}" >
        <a href="{{ route('manager.business.show', $business->slug) }}">
            <i class="fa fa-tachometer"></i>
            <span>{{ trans('nav.manager.left.dashboard') }}</span>
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