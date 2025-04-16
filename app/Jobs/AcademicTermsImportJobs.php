<?php

namespace App\Jobs;

use App\Imports\AcademicTermsImports;
use App\Models\AcademicTerms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AcademicTermsImportJobs implements ShouldQueue
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
        AcademicTerms::insert($this->data);
   }
}
