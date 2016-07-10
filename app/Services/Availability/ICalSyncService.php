<?php

namespace App\Services\Availability;

use App\Services\ICalChecker;
use Illuminate\Support\Facades\Storage;
use Timegridio\Concierge\Models\Humanresource;

class ICalSyncService
{
    protected $humanresource;

    public function __construct(Humanresource $humanresource)
    {
        $this->humanresource = $humanresource;
    }

    public function sync()
    {
        if (empty($this->humanresource->calendar_link)) {
            return false;
        }

        $icalFileContents = $this->getRemoteContents();

        Storage::put(
            $this->getFilePath("calendar-{$this->humanresource->slug}.ics"),
            $icalFileContents
        );

        $this->compile($this->humanresource->slug, $icalFileContents);
    }

    public function compile($slug, &$contents)
    {
        $icalchecker = new ICalChecker();

        $icalchecker->loadString($contents);

        $events = collect($icalchecker->all());

        $events = $events->map(function ($item) use ($slug) {
            return "{$slug}:{$item->getStart()->toDateString()}";
        })->unique()->sort();

        $compiled = implode("\n", $events->values()->all());

        $this->saveCompiled($compiled);
    }

    protected function saveCompiled($contents)
    {
        return Storage::append($this->getFilePath('ical-exclusion.compiled'), $contents);
    }

    public function getLocalContents()
    {
        $humanresourceSlug = $this->humanresource->slug;

        return Storage::get($this->getFilePath("calendar-{$humanresourceSlug}.ics"));
    }

    public function getRemoteContents()
    {
        return file_get_contents($this->humanresource->calendar_link);
    }

    protected function getFilePath($filename)
    {
        $businessId = $this->humanresource->business->id;

        return 'business'.DIRECTORY_SEPARATOR.
                $businessId.DIRECTORY_SEPARATOR.
                'ical'.DIRECTORY_SEPARATOR.
                $filename;
    }
}
