{{-- Language Switcher --}}
<li id="navLang" class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Config::get('languages')[App::getLocale()] }} <b class="caret"></b></a>
    <ul class="dropdown-menu">
        @foreach (Config::get('languages') as $lang => $language)
            @if ($lang != App::getLocale())
                <li>
                    {!! link_to_route('lang.switch', $language, $lang) !!}
                </li>
            @endif
        @endforeach
    </ul>
</li>
{{-- Language Switcher --}} 
