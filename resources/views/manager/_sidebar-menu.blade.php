<!-- Sidebar Menu -->
<ul class="sidebar-menu">

    <li class="header">{{ $business->name }}</li>
    <!-- Optionally, you can add icons to the links -->
    <li class="active" title="{{ $business->name }}" >
        <a href="{{ route('manager.business.show', $business->slug) }}">
            <i class="fa fa-home"></i>
            <span>{{ $business->name }}</span>
        </a>
    </li>

    <li title="{{ trans('manager.business.btn.tooltip.contacts') }}" >
        <a href="{{ route('manager.addressbook.index', $business) }}">
            <i class="fa fa-users"></i>
            <span>{{ trans('manager.business.btn.tooltip.contacts') }}</span>
        </a>
    </li>

    <li title="{{ trans('manager.business.btn.tooltip.vacancies') }}" >
        <a href="{{ route('manager.business.vacancy.create', $business) }}">
            <i class="fa fa-calendar-o"></i>
            <span>{{ trans('manager.business.btn.tooltip.vacancies') }}</span>
        </a>
    </li>

    <li title="{{ trans('manager.business.btn.tooltip.agenda') }}" >
        <a href="{{ route('manager.business.agenda.index', $business) }}">
            <i class="fa fa-calendar-check-o"></i>
            <span>{{ trans('manager.business.btn.tooltip.agenda') }}</span>
        </a>
    </li>

    <li title="{{ trans('manager.business.btn.tooltip.agenda') }}" >
        <a href="{{ route('manager.business.agenda.calendar', $business) }}">
            <i class="fa fa-calendar"></i>
            <span>{{ trans('manager.business.btn.tooltip.agenda') }}</span>
        </a>
    </li>

    <li title="{{ trans('manager.business.btn.tooltip.services') }}" >
        <a href="{{ route('manager.business.service.index', $business) }}">
            <i class="fa fa-tags"></i>
            <span>{{ trans('manager.business.btn.tooltip.services') }}</span>
        </a>
    </li>

    <li title="{{ trans('manager.business.btn.tooltip.humanresources') }}" >
        <a href="{{ route('manager.business.humanresource.index', $business) }}">
            <i class="fa fa-user-md"></i>
            <span>{{ trans('manager.business.btn.tooltip.humanresources') }}</span>
        </a>
    </li>

    <!-- Language Switcher -->
    @include('manager._sidebar-menu-i18n')

</ul>
<!-- /.sidebar-menu -->