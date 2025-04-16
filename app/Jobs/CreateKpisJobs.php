<?php

namespace App\Jobs;

use App\Models\Kpis;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateKpisJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels; 
    protected $data;        
    public function __construct($data)
    {   
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        if(is_array($this->data)) {
            Kpis::insert($this->data);
        } else {
            Kpis::create($this->data);
        }        
    }
}
