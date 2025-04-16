<?php

namespace App\Jobs;

use App\Traits\General;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendMailJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use General;
    protected $data;
    protected $view;
    public function __construct($data, $view)
    {   
        $this->data = $data;
        $this->view = $view;
    }

    public function handle(): void
    {                
        $this->sendmail($this->data, $this->view);
    }
}
