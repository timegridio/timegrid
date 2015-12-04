{{-- Language Switcher Dropdown --}}
<li id="navLang" class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        {{ Config::get('languages')[app()->getLocale()] }} <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        @foreach (Config::get('languages') as $lang => $language)
            @if ($lang != app()->getLocale())
                <li>
                    {!! link_to_route('lang.switch', $language, $lang) !!}
                </li>
            @endif
        @endforeach
    </ul>
</li>
{{-- Language Switcher Dropdown --}} 
