<?php

namespace App\Jobs;

use App\Imports\ReportSourcesImports;
use App\Models\ReportPriceListsBySources;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReportSourcesImportsJobs implements ShouldQueue
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
            ReportPriceListsBySources::insert($this->data);
        } else {
            ReportPriceListsBySources::create($this->data);
        }
    }
}
