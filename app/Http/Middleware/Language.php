<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
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
        logger()->info(__METHOD__);

        $sessionAppLocale = session()->get('applocale', null);

        if($sessionAppLocale == null)
        {
            $sessionAppLocale = $this->getAgentLangOrFallback(config('app.fallback_locale'));
        }

        logger()->info("sessionAppLocale:$sessionAppLocale");

        if (isAcceptedLocale($sessionAppLocale)) {
            setGlobalLocale($sessionAppLocale);
            logger()->info("setGlobalLocale set");

            return $next($request);
        }

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
        $agentLanguages = $this->agent->languages();
        $configLanguages = config('languages');

        logger()->info("Agent Languages: ".serialize($agentLanguages));
        logger()->info("Config Languages: ".serialize($configLanguages));

        if ($agentPreferredLocale = $this->searchAgent($agentLanguages, $configLanguages)) {

            logger()->info("Agent Preferred Locale: $agentPreferredLocale");
            return $agentPreferredLocale;
        }

        logger()->info("Using Fallback: $fallbackLocale");

        return $fallbackLocale;
    }

    /**
     * Search all AgentLangs aming app available Langs.
     *
     * @param array $agentPreferredLocale
     * @param array $appAcceptedLocales
     *
     * @return string
     */
    protected function searchAgent($agentPreferredLocale, $appAcceptedLocales)
    {
        $availableLangs = $this->normalizeArrayKeys($appAcceptedLocales);
        $agentPreferredLocale = $this->normalizeArrayValues($agentPreferredLocale);

        foreach ($agentPreferredLocale as $agentLang) {
            if ($matchedLocale = $this->compareAgentLang($availableLangs, $agentLang)) {
                return $matchedLocale;
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
