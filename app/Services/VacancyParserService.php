<?php

namespace App\Services;

class VacancyParserService
{
    const REGEX_PATTERN_VACANCY = '/(?P<services>.*)\n\ (?P<days>.*)\n\ \ (?<hours>.*)/im';

    /////////////////////
    // VACANCY PARSING //
    /////////////////////

    public function readVacancies($vacancyString)
    {
        preg_match_all(self::REGEX_PATTERN_VACANCY, $vacancyString, $matches, PREG_SET_ORDER);

        return $matches;
    }

    public function buildVacancies(array $vacancyParameters)
    {
        $services = $this->services($vacancyParameters['services']);
        $days = $this->dates($vacancyParameters['days']);
        $hourRanges = $this->hours($vacancyParameters['hours']);

        $builtVacancies = [];
        foreach ($services as $service) {
            foreach ($days as $day) {
                foreach ($hourRanges as $hourRange) {
                    $data = [
                        'service'  => $service['slug'],
                        'date'     => $day,
                        'startAt'  => $hourRange['startAt'],
                        'finishAt' => $hourRange['finishAt'],
                        'capacity' => $service['capacity'],
                    ];
                    // Avoid repeated sets
                    $key = md5(implode('.', $data));
                    $builtVacancies[$key] = $data;
                }
            }
        }

        return $builtVacancies;
    }

    public function parseStatements($stringStatements)
    {
        $vacancyStatements = $this->readVacancies($stringStatements);

        $builtVacancies = [];
        foreach ($vacancyStatements as $vacancyStatement) {
            $builtVacancies = array_merge($builtVacancies, $this->buildVacancies($vacancyStatement));
        }

        return $builtVacancies;
    }

    /////////////////////
    // SERVICE PARSING //
    /////////////////////

    public function services($services)
    {
        $services = $this->splitServices($services);

        return $this->getServicesCapacity($services);
    }

    public function splitServices($services)
    {
        return preg_split('/\ *\,\ */', $services);
    }

    public function getServicesCapacity(array $services)
    {
        $converted = [];
        foreach ($services as $service) {
            $converted[] = $this->getServiceCapacity($service);
        }

        return $converted;
    }

    public function getServiceCapacity($service)
    {
        $capacity = 1;
        if (strpos($service, ':') !== false) {
            list($service, $capacity) = explode(':', $service);
        }

        return ['slug' => $service, 'capacity' => $capacity];
    }

    //////////////////
    // DATE PARSING //
    //////////////////

    public function dates($days)
    {
        $days = $this->splitDates($days);

        return $this->convertDaysToDate($days);
    }

    public function splitDates($days)
    {
        return preg_split('/\ *\,\ */', $days);
    }

    public function convertDaysToDate(array $days)
    {
        $converted = [];
        foreach ($days as $day) {
            $converted[] = $this->dayToDate($day);
        }

        return $converted;
    }

    public function dayToDate($day)
    {
        return date('Y-m-d', strtotime($day));
    }

    //////////////////
    // TIME PARSING //
    //////////////////

    public function hours($string)
    {
        $ranges = $this->splitRanges($string);

        return $this->normalizeRanges($ranges);
    }

    public function normalizeRanges($ranges)
    {
        $normalizedRanges = [];

        foreach ($ranges as $range) {
            list($startAt, $finishAt) = preg_split('/\ *\-\ */', $range);
            $normalizedRanges[] = [
                'startAt'  => $this->milTimeToStandard($startAt),
                'finishAt' => $this->milTimeToStandard($finishAt),
            ];
        }

        return $normalizedRanges;
    }

    public function splitRanges($string)
    {
        return preg_split('/,\ */', $string);
    }

    public function milTimeToStandard($militaryTime)
    {
        $militaryTime = trim($militaryTime);

        if ($militaryTime == '') {
            return '';
        }

        if (strpos($militaryTime, ':') !== false) {
            return $militaryTime;
        }

        $parts = [];

        if (strlen($militaryTime) <= 2) {
            $parts[] = intval($militaryTime);
            $parts[] = '00';
        }
        if (strlen($militaryTime) == 3) {
            $parts[0] = substr($militaryTime, 0, 1);
            $parts[1] = substr($militaryTime, 1, 2);
        }
        if (strlen($militaryTime) == 4) {
            $parts[0] = substr($militaryTime, 0, 2);
            $parts[1] = substr($militaryTime, 2, 2);
        }

        return implode(':', $parts);
    }
}
