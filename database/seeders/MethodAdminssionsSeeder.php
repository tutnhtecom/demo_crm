<?php

namespace Database\Seeders;

use App\Models\MethodAdminssions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MethodAdminssionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        DB::table('method_adminssions')->delete();
        $dem = DB::table('method_adminssions')->whereNull('deleted_at')->count();        
        if($dem <= 0) {
            $data = [            
                ["name"  =>    "Văn bằng 1" ], 
                ["name"  =>    "Văn bằng 2"],
                ["name"  =>    "Liên thông"],
            ];
        DB::table('method_adminssions')->insert($data);
        }      
    }
}
