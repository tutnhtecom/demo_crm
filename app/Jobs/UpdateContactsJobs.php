<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateContactsJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $table;
    protected $data;
    protected $leads_conditions;
    protected $type_conditions;
    public function __construct($table, $leads_conditions, $type_conditions, $data)
    {   
        $this->table = $table;
        $this->data = $data;
        $this->leads_conditions = $leads_conditions;
        $this->type_conditions = $type_conditions;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::table($this->table)->where($this->leads_conditions)->where($this->leads_conditions)->update($this->data);
    }
}
