<?php

namespace Database\Seeders;

use App\Models\TransactionStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        $dem = TransactionStatus::count();
        if($dem <= 0) {
            $data = [            
                [ "name"  =>    "Bản nháp" ],
                [ "name"  =>    "Chờ chuyển khoản" ], 
                [ "name"  =>    "Đã hoàn thành"]
            ];
            TransactionStatus::insert($data);
        }      
              
       
    }
}
