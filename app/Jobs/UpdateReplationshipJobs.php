<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateReplationshipJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $table;
    protected $data;
    protected $coditions;
    public function __construct($table, $coditions, $data)
    {   
        $this->table = $table;
        $this->data = $data;
        $this->coditions = $coditions;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::table($this->table)->where($this->coditions)->update($this->data);
    }
}
