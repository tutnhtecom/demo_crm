<?php

namespace App\Console\Commands;

use App\Jobs\AutoCreateSemestersJob;
use Illuminate\Console\Command;

class AutoCreateSemestersCommand extends Command
{
    protected $signature = 'auto:create-semesters';
    protected $description = 'Tự động tạo học kỳ hàng năm';
    public function __construct()
    {
        parent::__construct();        
    }  
    public function handle()
    {
        AutoCreateSemestersJob::dispatch();
    }
}
