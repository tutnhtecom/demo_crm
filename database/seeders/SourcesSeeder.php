<?php

namespace Database\Seeders;

use App\Models\Sources;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dem = Sources::count();
        if($dem <= 0) {
            $data = [
                ["name" =>  "Facebook", "sources_types" => 1],
                ["name" =>  "Bạn bè", "sources_types" => 1],
                ["name" =>  "Website", "sources_types" => 1],
                ["name" =>  "Zalo", "sources_types" => 1]
            ];
            Sources::insert($data);
        }


    }
}
