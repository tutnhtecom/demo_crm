<?php

namespace App\Jobs;

use App\Models\EducationsTypes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateEducationTypeJobs implements ShouldQueue
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
        $params = $this->data;
        $status = EducationsTypes::where('id', $params['id'])->first();
        if(isset($status->id)) {
            $status->update($params);
        } else {            
            EducationsTypes::create($params);
        }
    }
}
