<?php

namespace App\Console\Commands;

use App\TransMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendRootReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'root:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Root Email Report';

    /**
     * @var App\TransMail
     */
    private $transmail;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TransMail $transmail)
    {
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
        logger()->info('Generating Root Report');

        //////////////////
        // FOR REFACTOR //
        //////////////////

        // Generate Root Report

        $registeredUsersCount = DB::table('users')->count();

        logger()->info('Users Count: '.$registeredUsersCount);

        // Mail to Root
        $params = [
            'registeredUsersCount' => $registeredUsersCount,
        ];
        $header = [
            'name'  => 'Root',
            'email' => config('root.report.to_mail'),
        ];
        $this->transmail->template('root.report')
                        ->subject('root.report.exceptions_subject')
                        ->send($header, $params);

        $this->info('Root report was sent');
    }
}
