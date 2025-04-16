<?php

namespace App\Jobs;

use App\Models\LeadsAcademicTerms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateLeadsAcademicTermJobs implements ShouldQueue
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
         LeadsAcademicTerms::create($this->data);
    }
}
