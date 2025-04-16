<?php

namespace App\Jobs;

use App\Models\DVLKTransactions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateDVLKTransactionsJobs implements ShouldQueue
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
            DVLKTransactions::insert($this->data);
        } else {
            DVLKTransactions::create($this->data);
        }       
    }
}
