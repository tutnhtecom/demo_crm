<?php

namespace Database\Seeders;

use App\Models\TransactionTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {    
        DB::table('transactions_types')->delete();        
        $dem = DB::table('transactions_types')->whereNull('deleted_at')->count();        
        if($dem <= 0) {
            $data = [            
                ["name"  =>    "Học phí"],
                ["name"  =>    "Phụ phí" ], 
        ];
        DB::table('transactions_types')->insert($data);
        }          
       
    }
}
