<?php

namespace App\Jobs;

use App\Models\Transactions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateMultipleTranslateJob implements ShouldQueue
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
            Transactions::insert($this->data);
        } else {
            Transactions::with(['leads.employees'])->create($this->data);
        }        
    }
}
