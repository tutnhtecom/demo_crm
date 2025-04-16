<?php

namespace App\Jobs;

use App\Models\Employees;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class EmployeesImportJobs implements ShouldQueue
{
    
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
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
            Employees::insert($this->eData);
        } else {
            Employees::create($this->eData);
        }        
    }
}
