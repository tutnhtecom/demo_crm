<?php

namespace App\Jobs;

use App\Models\SourcesPricesLists;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportSourcePriceListJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $eData;        
    public function __construct($data)
    {   
        $this->eData = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        if(is_array($this->eData)) {
            SourcesPricesLists::insert($this->eData);
        } else {
            SourcesPricesLists::create($this->eData);
        }        
    }
}
