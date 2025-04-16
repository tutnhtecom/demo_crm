<?php

namespace Database\Seeders;

use App\Jobs\CreateEmailTemplateTypesJobs;
use App\Models\EmailTemplateTypes;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        $data = [                       
            ["id" => 1, "name" =>  "Yêu cầu hỗ trợ", "created_at" => Carbon::now(), "created_by" => 1], 
            ["id" => 2, "name" =>  "Thí sinh mới", "created_at" => Carbon::now(), "created_by" => 1], 
            ["id" => 3, "name" =>  "Thông báo học phí", "created_at" => Carbon::now(), "created_by" => 1], 
            ["id" => 4, "name" =>  "Thông báo", "created_at" => Carbon::now(), "created_by" => 1],
            ["id" => 5, "name" =>  "Thông báo tài khoản sinh viên", "created_at" => Carbon::now(), "created_by" => 1], 
            ["id" => 6, "name" =>  "Thông báo tài khoản nhân sự", "created_at" => Carbon::now(), "created_by" => 1], 
            ["id" => 7, "name" =>  "Thông báo Giao việc (Task) ", "created_at" => Carbon::now(), "created_by" => 1], 
            ["id" => 8, "name" =>  "Thông tin Chỉ tiêu tuyển sinh (Kpis)", "created_at" => Carbon::now(), "created_by" => 1], 
        ];
        
        $new_data = [];
        foreach ($data as $key => $item) {
            $count = EmailTemplateTypes::where('id', $item['id'])->count();            
            if($count <= 0) {
                $new_data[] = $item;
            }
        }  
        EmailTemplateTypes::insert($new_data);              
    }
}
