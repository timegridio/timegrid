<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Services\ConciergeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
     * @var ConciergeService
     */
    protected $concierge;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConciergeService $concierge)
    {
        $this->concierge = $concierge;

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
        $this->info("Sending to businessId:{$business->id}");
        $appointments = $this->concierge->setBusiness($business)->getActiveAppointments();

        $locale = $business->locale ?: app()->getLocale();
        app()->setLocale($locale);

        // Mail to User
        $mailParams = [
            'business'     => $business,
            'appointments' => $appointments,
        ];

        $viewKey = "emails.{$locale}.appointments.manager._schedule";

        Mail::send($viewKey, $mailParams, function ($mail) use ($business) {
            $mail->to($business->owners()->first()->email, $business->owners()->first()->name)
                 ->subject(trans('emails.manager.business.report.subject', [
                    'date'     => date('Y-m-d'),
                    'business' => $business->name,
                    ]));
        });
    }
}
