<?php

namespace App\Jobs;

use App\Models\Kpis;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class DeleteKpisJob implements ShouldQueue
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
        Kpis::where("semesters_id", $params["semesters_id"])->where("from_date", '<=', $params["from_date"])->where("to_date", ">=", $params["to_date"] )->delete();
    }
}
