<?php

namespace App\Console\Commands;

use App\Mail\invoice_mail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class send_invoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email with pdf invoice at the end of every month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users=User::get();
        //請求日
        $month=Carbon::today()->format('m');
        foreach($users as $user){
            return redirect()->route('invoice_mail')->with(compact('user','month'));
        }
    }
}
