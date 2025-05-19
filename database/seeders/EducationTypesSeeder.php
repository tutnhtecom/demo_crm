<?php

namespace Database\Seeders;

use App\Jobs\UpdateEducationTypeJobs;
use App\Models\EducationsTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        DB::table('educations_types')->delete(); 
        $data = [
            ["id" => 1, "name"  => "Tốt nghiệp THPT"],
            ["id" => 2, "name"  => "Trung cấp"],
            ["id" => 3, "name"  => "Cao đẳng"],
            ["id" => 4, "name"  => "Đại học"],
            ["id" => 5, "name"  => "Khác"],
        ]; 
        EducationsTypes::insert($data);
        // foreach ($data as $item) {
        //     UpdateEducationTypeJobs::dispatch($item);
        // }
    }
}
