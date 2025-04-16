<?php

namespace App\Console\Commands;

use App\Jobs\SendMailHappyBirtdayJobs;
use App\Services\Leads\LeadsInterface;
use Illuminate\Console\Command;

class SendMailHappyBirtday extends Command
{
    protected $signature = 'happy:birthday';
    protected $description = 'Lời chúc mừng sinh nhật tới sinh viên';    
    public function __construct()
    {
        parent::__construct();        
    }    

    public function handle()
    {
        SendMailHappyBirtdayJobs::dispatch();
    }
}
