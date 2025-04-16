<?php

namespace App\Console\Commands;

use App\Jobs\KpisAutoJobs;
use Illuminate\Console\Command;

class KpisAutoStoreNextMonthCommands extends Command
{
    protected $signature = 'auto:kpis';
    protected $description = 'Tự động lưu Kpis sang tháng tiếp theo';
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {                      
        dispatch(new KpisAutoJobs());

    }
}
