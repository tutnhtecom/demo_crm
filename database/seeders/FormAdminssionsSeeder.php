<?php

namespace Database\Seeders;

use App\Models\FormAdminssions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormAdminssionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $dem = FormAdminssions::count();
        if($dem <= 0) {
            $data = [           
                ["name"  =>    "Đào tạo onilne"], 
                ["name"  =>    "Đào tạo tại trung tâm"]
             ];
             FormAdminssions::insert($data);
        }            
       
    }
}
