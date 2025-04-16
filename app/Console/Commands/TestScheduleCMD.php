<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestScheduleCMD extends Command
{
    protected $signature = 'auto:test';
    protected $description = 'Kiểm tra hệ thống auto';
    public function __construct()
    {
        parent::__construct();        
    }  
    public function handle()
    {
        Log::info("Test Kernel: Chạy vào lúc:  ". Carbon::now()->format("H:i:s") . " phút lưu một lần");
    }
}
