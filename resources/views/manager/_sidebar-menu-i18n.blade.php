{{-- Language Switcher Dropdown --}}
<li class="treeview">
    <a href="#"><i class="fa fa-link"></i> <span>{{ $availableLanguages[app()->getLocale()] }}</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        @foreach ($availableLanguages as $locale => $language)
            @if ($locale != app()->getLocale())
                <li>
                    {!! link_to_route('lang.switch', $language, $locale) !!}
                </li>
            @endif
        @endforeach
    </ul>
</li>
{{-- Language Switcher Dropdown --}}
