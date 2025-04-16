<?php

namespace Database\Seeders;

use App\Models\ConfigSemesters;
use Illuminate\Database\Seeder;

class ConfigSemestersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dem = ConfigSemesters::count();
        if($dem <= 0) {
            $data = [
                ["name" => "Học kỳ 1","from_day" => "25", "from_month"  => "11", "to_day" => "23", "to_month" => "03"],
                ["name" => "Học kỳ 2","from_day" => "24", "from_month"  => "03", "to_day" => "27", "to_month" => "07"],
                ["name" => "Học kỳ 3","from_day" => "28", "from_month"  => "07", "to_day" => "23", "to_month" => "11"],
            ];
            ConfigSemesters::insert($data);
        }       
    }
}
