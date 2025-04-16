<?php

namespace Database\Seeders;

use App\Models\LineVoip;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LineVoipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('line_voip')->delete();
        $dem = LineVoip::count();
        if($dem <= 0) {
            $data = [
                [
                    'id' => 1,
                    'line_id' => 615,
                    'line_password' => 'grsder6e@voih.vn',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 2,
                    'line_id' => 616,
                    'line_password' => 'demo@voip24h.vn',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]; 
            DB::table('line_voip')->insert($data);
        }
    }
}
