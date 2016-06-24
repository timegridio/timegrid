<?php

namespace App\Console\Commands;

use App\TransMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Vacancy\VacancyParser;

class AutopublishBusinessVacancies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:vacancies {business?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Autopublish Business Vacancies';

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
     * @var VacancyParser
     */
    protected $vacancyParser;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Concierge $concierge, TransMail $transmail, VacancyParser $vacancyParser)
    {
        $this->concierge = $concierge;

        $this->transmail = $transmail;

        $this->vacancyParser = $vacancyParser;

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
            $this->info("Publishing for specified businessId:{$businessId}");
            $business = Business::findOrFail($businessId);
            $this->publishVacancies($business);
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
            ['business', InputArgument::OPTIONAL, 'Business to publish vacancies.'],
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
            $this->publishVacancies($business);
        }
    }

    /**
     * send Business Report.
     *
     * @param Business $business
     *
     * @return void
     */
    protected function publishVacancies(Business $business)
    {
        $this->info(__CLASS__.':'.__METHOD__);
        $this->info("Publishing vacancies for businessId:{$business->id}");

        $publishedVacancies = $this->vacancyParser->parseStatements($this->recallStatements($business->id));

        if (!$this->autopublishVacancies($business)) {
            $this->info('Skipped autopublishing vacancies');

            return false;
        }

        if (!$this->concierge->business($business)->vacancies()->updateBatch($business, $publishedVacancies)) {
            return false;
        }

//        $owner = $business->owners()->first();

        // Mail to User
//        $header = [
//            'email' => $owner->email,
//            'name'  => $owner->name,
//        ];
//        $this->transmail->locale($business->locale)
//                        ->template('appointments.manager._schedule')
//                        ->subject('manager.business.report.subject', ['date' => date('Y-m-d'), 'business' => $business->name])
//                        ->send($header, compact('business', 'appointments'));

        return true;
    }

    protected function autopublishVacancies(Business $business)
    {
        return $business->pref('vacancy_autopublish');
    }

    protected function recallStatements($businessId)
    {
        if (!Storage::exists($this->getStatementsFile($businessId))) {
            return;
        }

        return Storage::get(
            $this->getStatementsFile($businessId)
        );
    }

    protected function getStatementsFile($businessId)
    {
        return 'business'.DIRECTORY_SEPARATOR.$businessId.DIRECTORY_SEPARATOR.'vacancy-statements.txt';
    }
}
