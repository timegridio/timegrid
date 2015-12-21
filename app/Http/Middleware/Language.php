<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Support\Facades\Config;
use Jenssegers\Agent\Agent;

class Language implements Middleware
{
    /**
     * Agent information gather class.
     *
     * @var Jenssegers\Agent\Facades\Agent
     */
    private $agent;

    /**
     * Create the class.
     *
     * @param Agent $agent
     */
    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function handle($request, Closure $next)
    {
        $sessionAppLocale = session()->get('applocale');

        if (session()->has('applocale') and array_key_exists($sessionAppLocale, Config::get('languages'))) {
            app()->setLocale($sessionAppLocale);
            setlocale(LC_TIME, $sessionAppLocale);
            Carbon::setLocale(\Locale::getPrimaryLanguage($sessionAppLocale));

            return $next($request);
        }

        $fallbackLocale = $this->getAgentLangOrFallback(Config::get('app.fallback_locale'));

        app()->setLocale($fallbackLocale);
        setlocale(LC_TIME, $fallbackLocale);
        Carbon::setLocale(\Locale::getPrimaryLanguage($fallbackLocale));

        return $next($request);
    }

    /////////////
    // Helpers //
    /////////////

    /**
     * Get accepted Lang from Agent Or Fallback to default locale.
     *
     * @return string
     */
    protected function getAgentLangOrFallback($fallbackLocale)
    {
        $configLangs = Config::get('languages');
        $agentLangs = $this->agent->languages();

        $availableLangs = $this->normalizeArrayKeys($configLangs);
        $agentLangs = $this->normalizeArrayValues($agentLangs);

        if ($locale = $this->searchAgent($agentLangs, $availableLangs)) {
            return $locale;
        }

        return $fallbackLocale;
    }

    /**
     * Search all AgentLangs aming app available Langs.
     *
     * @param array $agentLangs
     * @param array $availableLangs
     *
     * @return string
     */
    protected function searchAgent($agentLangs, $availableLangs)
    {
        foreach ($agentLangs as $agentLang) {
            if ($locale = $this->compareAgentLang($availableLangs, $agentLang)) {
                return $locale;
            }
        }
    }

    /**
     * Search for an AgentLang among app available Langs.
     *
     * EXAMPLE MATCH
     * "en_us" "en_us.utf8" : true
     * "en"    "en_us.utf8" : true
     * "es"    "es_es.utf8" : true
     * "en_us" "es_es.utf8" : false
     * "es_ar" "es_es.utf8" : false
     *
     * @param array  $availableLangs
     * @param string $agentLang
     *
     * @return string|false
     */
    protected function compareAgentLang(array $availableLangs, $agentLang)
    {
        foreach ($availableLangs as $availableKey => $availableLang) {
            if (stripos($availableLang, $agentLang) !== false) {
                return $availableKey;
            }
        }

        return false;
    }

    /**
     * Copy keys as lowercase values.
     *
     * EXAMPLE CONVERSION
     * array:2 [                   >> array:2 [
     *   "en_US.utf8" => "English" >>   "en_US.utf8" => "en_us.utf8"
     *   "es_ES.utf8" => "Español" >>   "es_ES.utf8" => "es_es.utf8"
     * ]                           >> ]
     *
     * @param array $array
     *
     * @return array
     */
    protected function normalizeArrayKeys(array $array)
    {
        array_walk($array, function (&$value, $key) {
            $value = strtolower($key);
        });

        return $array;
    }

    /**
     * Change values to lowercase and undescored instead of dashed.
     *
     * EXAMPLE CONVERSION
     * array:3 [      >> array:3 [
     *   0 => "es"    >>   0 => "es"
     *   1 => "en-us" >>   1 => "en_us"
     *   2 => "en"    >>   2 => "en"
     * ]              >> ]
     *
     * @param array $array
     *
     * @return array
     */
    protected function normalizeArrayValues(array $array)
    {
        array_walk($array, function (&$value) {
            $value = str_replace('-', '_', strtolower($value));
        });

        return $array;
    }
}
