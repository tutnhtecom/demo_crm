<?php

namespace App\Jobs;

use App\Models\DVLKSemesters;
use App\Models\Leads;
use App\Models\Students;
use App\Services\Leads\LeadsInterface;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendMailHappyBirtdayJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, General;
    protected $leads_interface;
    public function __construct(LeadsInterface $leads_interface)
    {
        $this->leads_interface = $leads_interface;
    }
    public function handle(): void
    {            
        Log::info("Luu log: Chuc mung sinh nhat");
        $this->leads_interface->get_notification_birthday();
    }
}
