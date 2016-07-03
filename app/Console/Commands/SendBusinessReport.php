<?php

namespace App\Console\Commands;

use App\TransMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;

class SendBusinessReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:report {business?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Business report';

    /**
     * Concierge Service.
     *
     * @var Timegridio\Concierge\Concierge
     */
    protected $concierge;

    /**
     * @var TransMail
     */
    protected $transmail;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Concierge $concierge, TransMail $transmail)
    {
        $this->concierge = $concierge;

        $this->transmail = $transmail;

        parent::__construct();
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
            $this->info('Scanning all businesses...');
            $this->scanBusinesses();
        } else {
            $this->info("Sending to specified businessId:{$businessId}");
            $business = Business::findOrFail($businessId);
            $this->sendBusinessReport($business);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['business', InputArgument::OPTIONAL, 'Business to generate the report.'],
        ];
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
            $this->sendBusinessReport($business);
        }
    }

    /**
     * send Business Report.
     *
     * @param Business $business
     *
     * @return void
     */
    protected function sendBusinessReport(Business $business)
    {
        $this->info(__CLASS__.':'.__METHOD__);
        $this->info("Sending to businessId:{$business->id}");

        $appointments = $this->concierge->business($business)->getActiveAppointments();

        if ($this->skipReport($business, count($appointments))) {
            $this->info("Skipped report");
            return false;
        }

        $owner = $business->owners()->first();

        // Mail to User
        $ownerName = $owner->name;
        $businessName = $business->name;
        $date = date('Y-m-d');
        $header = [
            'email' => $owner->email,
            'name'  => $ownerName,
        ];
        $this->transmail->locale($business->locale)
                        ->timezone($business->timezone)
                        ->template('manager.business-report.schedule')
                        ->subject('manager.business-report.subject', compact('businessName', 'date'))
                        ->send($header, compact('business', 'appointments', 'ownerName'));

        return true;
    }

    protected function skipReport(Business $business, $appointmentsCount)
    {
        return !($this->enabledReports($business) && $this->hasAppointments($appointmentsCount));
    }

    protected function enabledReports(Business $business)
    {
        return $business->pref('report_daily_schedule');
    }

    protected function hasAppointments($appointmentsCount)
    {
        return 0 != $appointmentsCount;
    }
}
