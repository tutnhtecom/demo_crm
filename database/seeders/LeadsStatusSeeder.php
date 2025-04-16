<?php

namespace Database\Seeders;

use App\Jobs\UpdateStatusSeederJobs;
use App\Models\LstStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LeadsStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["id"=>1,"name"=>"Mới","color"=>"rgba(30, 187, 121, 1)","bg_color"=>"rgba(30, 187, 121, 0.15)","border_color"=>"rgba(30, 187, 121, 1)","created_at"=>"2024-10-24 05:43:07","created_by"=>"1", "is_default" => 0],
            ["id"=>2,"name"=>"Không liên lạc được","color"=>"rgba(255, 166, 0, 1)","bg_color"=>"rgba(255, 166, 0, 0.15)","border_color"=>"rgba(255, 166, 0, 1)","created_at"=>"2024-10-24 05:43:07","created_by"=>"1", "is_default" => 0],
            ["id"=>3,"name"=>"Đang cân nhắc","color"=>"rgba(56, 126, 193, 1)","bg_color"=>"rgba(56, 126, 193, 0.15)","border_color"=>"rgba(56, 126, 193, 1)","created_at"=>"2024-10-24 05:43:07","created_by"=>"1", "is_default" => 0],
            ["id"=>4,"name"=>"Đăng ký hồ sơ","color"=>"rgba(255, 86, 48, 1)","bg_color"=>"rgba(255, 86, 48, 0.15)","border_color"=>"rgba(255, 86, 48, 1)","created_at"=>"2024-10-24 05:43:07","created_by"=>"1", "is_default" => 1],
            ["id"=>5,"name"=>"Đã nộp hồ sơ","color"=>"rgba(142, 36, 170, 1)","bg_color"=>"rgba(142, 36, 170, 0.15)","border_color"=>"rgba(142, 36, 170, 1)","created_at"=>"2024-10-24 05:43:07","created_by"=>"1", "is_default" => 1],
            ["id"=>6,"name"=>"Đã đóng học phí","color"=>"rgba(0, 150, 136, 1)","bg_color"=>"rgba(0, 150, 136, 0.15)","border_color"=>"rgba(0, 150, 136, 1)","created_at"=>"2024-10-24 05:43:07","created_by"=>"1", "is_default" => 1],
            ["id"=>7,"name"=>"Không tham gia học","color"=>"rgba(233, 30, 99, 1)","bg_color"=>"rgba(233, 30, 99, 0.15)","border_color"=>"rgba(233, 30, 99, 1)","created_at"=>"2024-10-24 05:43:07","created_by"=>"1", "is_default" => 0],
        ];
        foreach ($data as $item) {
            UpdateStatusSeederJobs::dispatch($item);
        }
    }
}
