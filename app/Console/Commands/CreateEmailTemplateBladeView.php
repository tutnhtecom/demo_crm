<?php

namespace App\Console\Commands;

use App\Models\EmailTemplates;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CreateEmailTemplateBladeView extends Command
{
    protected $signature = 'make:blade {data}';
    protected $description = 'Tạo file blade trong dư án';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        try {
            $data = $this->argument('data');
            $name = $data['file_name'];            
            $path = resource_path("views/includes/template/{$name}.blade.php");

            // Kiểm tra nếu file đã tồn tại
            if (File::exists($path)) {
                $this->error("Blade view {$name} already exists!");
                return;
            }
            // Tạo thư mục nếu chưa tồn tại
            File::ensureDirectoryExists(dirname($path));

            // Tạo file Blade với nội dung mặc định (nếu muốn)
            File::put($path, json_decode($data['content']));

            $this->info("Blade view {$name}.blade.php created successfully.");
        } catch (\Throwable $th) {            
            Log::error($th->getMessage());
            return $th->getMessage();
        }
    }
}
