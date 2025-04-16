<?php

namespace App\Jobs;

use App\Models\ConfigSemesters;
use App\Models\Semesters;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateSemestersConfigsJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        if(is_array($this->data)) {
            Semesters::insert($this->data);
        } else {
            Semesters::create($this->data);
        }       
    }
}
