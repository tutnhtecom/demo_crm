<?php

namespace App\Jobs;

use App\Models\SourcesDocuments;
use App\Models\SourcesRates;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SourcesRatesImportJobs implements ShouldQueue
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
            SourcesRates::insert($this->data);
        } else {
            SourcesRates::create($this->data);
        }
    }
}
