<?php

namespace Database\Seeders;

use App\Models\Tags;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {     
          
        $dem = Tags::count();
        if($dem <= 0) {
            $data = [              
                [ "name"  =>    "Đang tư vấn" ], 
                [ "name"  =>    "Nộp hồ sơ online" ], 
                [ "name"  =>    "Bạn bè giới thiệu" ]
            ];
            Tags::insert($data);
        }      
        
    }
}
