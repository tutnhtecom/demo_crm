<?php

namespace Database\Seeders;

use App\Jobs\UpdateMajorsJob;
use App\Models\Marjors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarjorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {     
        $data = [
            ["id" => 1, "code" => "KTCTXD", "name"  => "Công nghệ kỹ thuật công trình xây dựng"],
            ["id" => 2, "code" => "CNTT", "name"  => "Công nghệ thông tin"],
            ["id" => 3, "code" => "ĐNAH", "name"  => "Đông Nam Á Học"],
            ["id" => 4, "code" => "CNDL", "name"  => "Du lịch"]
        ]; 
        Marjors::insert($data);
        // foreach ($data as $item) {
        //     UpdateMajorsJob::dispatch($item);
        // }     
       
    }
}
