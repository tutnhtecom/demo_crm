<?php

namespace Database\Seeders;

use App\Jobs\UpdateBlockAdminssionsJob;
use App\Models\BlockAdminssions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlockAdminssionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {      

        $data = [
            ["id" => 1,"marjors_id" => 1, "name"=>"(A00) # Toán, Vật lý, Hóa học", "code"=> "KTXDA01", "subject"=> "Toán, Vật lý, Hóa học"],
            ["id" => 2,"marjors_id" => 1, "name"=>"(A01) # Toán, Vật lý, Tiếng anh", "code"=> "KTXDA02", "subject"=> "Toán, Vật lý, Tiếng anh" ],
            ["id" => 3,"marjors_id" => 1, "name"=>"(D01) # Toán, Văn học, Tiếng anh","code"=> "KTXDD01", "subject"=> "Toán, Văn học, Tiếng anh"],
            ["id" => 4,"marjors_id" => 2, "name"=>"(A00) # Toán, Vật lý, Hóa học", "code"=> "CNTTA01", "subject"=> "Toán, Vật lý, Hóa học"],
            ["id" => 5,"marjors_id" => 2, "name"=>"(A01) # Toán, Vật lý, Tiếng anh", "code"=> "CNTTA02", "subject"=> "Toán, Vật lý, Tiếng anh" ],
            ["id" => 6,"marjors_id" => 2, "name"=>"(D01) # Toán, Văn học, Tiếng anh","code"=> "CNTTD01", "subject"=> "Toán, Văn học, Tiếng anh"]
        ];
        BlockAdminssions::insert($data);
        // foreach ($data as $item) {
        //     UpdateBlockAdminssionsJob::dispatch($item);
        // } 
        
    }
}
