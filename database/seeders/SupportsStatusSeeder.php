<?php

namespace Database\Seeders;

use App\Models\SupportsStatus;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupportsStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {     
        DB::table('supports_status')->delete();
        $data = [    
            
            ["id"=>1,"name"=>"Mới","color"=>"rgb(252, 5, 5)","bg_color"=>"rgba(211, 86, 86, 0.2)","border_color"=>"rgb(252, 5, 5)","created_at"=>Carbon::now(),"created_by"=>"1"],
            ["id"=>2,"name"=>"Mở","color"=>"rgb(17, 0, 255)","bg_color"=>"rgba(17, 0, 255, 0.2)","border_color"=>"rgb(17, 0, 255)","created_at"=>Carbon::now(),"created_by"=>"1"],
            ["id"=>3,"name"=>"Đã trả lời","color"=>"rgba(61, 201, 84, 1)","bg_color"=>"rgba(61, 201, 84, 0.2)","border_color"=>"rgba(61, 201, 84, 1)","created_at"=>Carbon::now(),"created_by"=>"1"],
            ["id"=>4,"name"=>"Đóng","color"=>"rgba(0, 0, 0, 1)","bg_color"=>"rgba(0, 0, 0, 0.2)","border_color"=>"rgba(0, 0, 0, 1)","created_at"=>Carbon::now(),"created_by"=>"1"],
       ];       
       SupportsStatus::insert($data);
       
    }
}
