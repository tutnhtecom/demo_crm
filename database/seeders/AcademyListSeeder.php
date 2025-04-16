<?php

namespace Database\Seeders;

use App\Models\AcademyList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademyListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["id" => 1, "name"=>"Khóa 1"],
            ["id" => 2, "name"=>"Khóa 2"],
            ["id" => 3, "name"=>"Khóa 3"],
            ["id" => 4, "name"=>"Khóa 4"],
        ];
        AcademyList::insert($data);
    }
}
