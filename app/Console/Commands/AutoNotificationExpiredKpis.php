<?php

namespace App\Console\Commands;

use App\Jobs\AutoNotificationExpiredKpisJobs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoNotificationExpiredKpis extends Command
{    
    protected $signature = 'auto:notification-kpis-expired';
    protected $description = 'Thông báo kỳ hạn thực hiện chỉ tiêu tuyển sinh';
    public function handle()
    {
        Log::info("Thong bao");
        AutoNotificationExpiredKpisJobs::dispatch();
    }
}
