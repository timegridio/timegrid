<?php

namespace App\Console\Commands;

// use App\Jobs\FetchICalFile;
use App\TG\Availability\ICalSyncService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Timegridio\Concierge\Models\Business;

class SyncICal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ical:sync {business?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync ICal';

    /**
     * @var App\TG\Availability\ICalSyncService
     */
    protected $icalsync;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ICalSyncService $icalsync)
    {
        parent::__construct();

        $this->icalsync = $icalsync;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $businessId = $this->argument('business');

        if ($businessId === null) {
            $this->info('Syncing ICal for all businesses');
            $this->scanBusinesses();

            return 0;
        }

        $this->info("Syncing ICal for {$businessId}");

        $business = Business::findOrFail($businessId);

        $this->processBusiness($business);
    }

    /**
     * scan Businesses.
     *
     * @return void
     */
    protected function scanBusinesses()
    {
        $businesses = Business::all();
        foreach ($businesses as $business) {
            $this->processBusiness($business);
        }
    }

    protected function processBusiness(Business $business)
    {
        $humanresources = $business->humanresources()->whereNotNull('calendar_link')->get();

        if ($humanresources) {
            Storage::delete("business/{$business->id}/ical/ical-exclusion.compiled");
        }

        $this->processHumanresources($humanresources);
    }

    protected function processHumanresources($humanresources)
    {
        foreach ($humanresources as $humanresource) {
            // dispatch(new FetchICalFile($humanresource));
            $this->icalsync->humanresource($humanresource)->sync();
        }
    }
}
