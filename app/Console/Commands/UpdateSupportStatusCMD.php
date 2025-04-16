<?php

namespace App\Console\Commands;

use App\Jobs\UpdateStatusForSupportJob;
use App\Services\Supports\SupportsInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateSupportStatusCMD extends Command
{
    protected $signature = 'auto:update_status_for_supports';
    protected $description = 'Cập nhật trạng thái của Yêu cầu hỗ trợ';
    // protected $sp_interface;
    // SupportsInterface $sp_interface
    public function __construct()
    {
        // $this->sp_interface = $sp_interface;
        parent::__construct();        
    }  
    public function handle()
    {
        // $this->sp_interface->auto_update_status_support();
        UpdateStatusForSupportJob::dispatch();
    }
}
