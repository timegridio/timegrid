<?php

namespace App\TG\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class ReverseTranslator
{
    protected $languageGroups = [];

    protected function loadGroups($locale)
    {
        // Iterate through all available groups and store
        $languagePath = resource_path("lang/{$locale}/");
        $languageGroups = array_map(function ($file) use ($languagePath) {
            return str_replace([$languagePath, '.php'], '', $file);
        }, File::glob($languagePath.'*.php'));

        $this->languageGroups[$locale] = $languageGroups;

        return $languageGroups;
    }

    protected function lowercase($value)
    {
        return is_array($value) ? array_map([$this, 'lowercase'], $value) : Str::lower($value);
    }

    protected function arraySearchRecursive($search, array $array, $mode = 'value', $return = false)
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));
        foreach ($iterator as $key => $value) {
            if ($search == $value) {
                $keys = [];
                for ($i = $iterator->getDepth() - 1; $i >= 0; $i--) {
                    $keys[] = $iterator->getSubIterator($i)->key();
                }
                $keys[] = $key;

                return implode('.', $keys);
            }
        }

        return false;
    }

    protected function search($foreign, $group, $locale = 'en')
    {
        // Load all strings for group in current language
        $groupStrings = trans($group);

        // Recursive and case-insensitive search
        return $this->arraySearchRecursive($this->lowercase($foreign), $this->lowercase($groupStrings));
    }

    public function get($foreign, $group = null, $locale = 'en')
    {
        if (!$group) {
            if (!isset($this->languageGroups[$locale])) {
                $this->loadGroups($locale);
            }
            foreach ($this->languageGroups[$locale] as $group) {
                $key = $this->search($foreign, $group, $locale);
                if ($key !== false) {
                    return trans("{$group}.{$key}", [], null, $locale);
                }
            }
            // Failed to match -- return original string
            return $foreign;
        }

        $key = $this->search($foreign, $group, $locale);
        if ($key !== false) {
            return trans("{$group}.{$key}", [], null, $locale);
        }

        // Failed to match -- return original string
        return $foreign;
    }
}
