{{-- Language Switcher Dropdown --}}
<li id="navLang" class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        {{ $availableLanguages[$appLocale] }} <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
    @foreach ($availableLanguages as $locale => $language)
        @if ($locale != $appLocale)
        <li>
            {!! link_to_route('lang.switch', $language, $locale) !!}
        </li>
        @endif
    @endforeach
    </ul>
</li>
{{-- Language Switcher Dropdown --}} 
