<?php

namespace App\Jobs;

use App\Services\Kpis\KpisInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class KpisAutoJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $kpis_interface;
       
    public function handle(KpisInterface $kpis_interface): void
    {        
        $this->kpis_interface = $kpis_interface;
        $this->kpis_interface->cron_data();
    }
}
