<?php

namespace App\Jobs;

use App\Services\Availability\ICalSyncService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Humanresource;

class FetchICalFile extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $humanresource;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Humanresource $humanresource)
    {
        $this->humanresource = $humanresource;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger()->info(__METHOD__);

        // $this->resetCompiled($this->business->id);

        $this->sync($this->humanresource);
    }

    protected function sync($humanresource)
    {
        $icalsync = new ICalSyncService($humanresource);

        $icalsync->sync();
    }
}
