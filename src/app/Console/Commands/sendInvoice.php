<?php

namespace App\Console\Commands;

use App\Http\Controllers\writePdfController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class sendInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendInvoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '毎月のはじめに請求書を送る';

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
        Log::info('start');
        writePdfController::index();
        Log::info('end');
        return 0;
    }
}
