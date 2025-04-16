<?php

namespace Database\Seeders;

use App\Models\RolePermissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles_permissions')->delete();
        $data = [            
            ["id"=>1, "roles_id"=>1,"permissions_id"=>1],
            ["id"=>2, "roles_id"=>1,"permissions_id"=>2],
            ["id"=>3, "roles_id"=>1,"permissions_id"=>3],
            ["id"=>4, "roles_id"=>1,"permissions_id"=>4],
            ["id"=>5, "roles_id"=>1,"permissions_id"=>5],
            ["id"=>6, "roles_id"=>1,"permissions_id"=>6],
            ["id"=>7, "roles_id"=>1,"permissions_id"=>7],
            ["id"=>8, "roles_id"=>1,"permissions_id"=>8],
            ["id"=>9, "roles_id"=>1,"permissions_id"=>9],
            ["id"=>10, "roles_id"=>1,"permissions_id"=>10],
            ["id"=>11, "roles_id"=>1,"permissions_id"=>11],
            ["id"=>12, "roles_id"=>1,"permissions_id"=>12],
            ["id"=>13, "roles_id"=>1,"permissions_id"=>13],
            ["id"=>14, "roles_id"=>1,"permissions_id"=>14],
            ["id"=>15, "roles_id"=>1,"permissions_id"=>15],
            ["id"=>16, "roles_id"=>1,"permissions_id"=>16],
            ["id"=>17, "roles_id"=>1,"permissions_id"=>17],
            ["id"=>18, "roles_id"=>2,"permissions_id"=>10],
            ["id"=>19, "roles_id"=>2,"permissions_id"=>11],
            ["id"=>20, "roles_id"=>2,"permissions_id"=>12],
            ["id"=>21, "roles_id"=>2,"permissions_id"=>13],
            ["id"=>22, "roles_id"=>2,"permissions_id"=>14],
            ["id"=>23, "roles_id"=>2,"permissions_id"=>15],
            ["id"=>24, "roles_id"=>2,"permissions_id"=>16],
            ["id"=>25, "roles_id"=>2,"permissions_id"=>17],
            ["id"=>26, "roles_id"=>2,"permissions_id"=>18],
            ["id"=>27, "roles_id"=>2,"permissions_id"=>19],
            ["id"=>28, "roles_id"=>2,"permissions_id"=>20],
            ["id"=>29, "roles_id"=>2,"permissions_id"=>21],
            ["id"=>30, "roles_id"=>2,"permissions_id"=>22],
            ["id"=>31, "roles_id"=>2,"permissions_id"=>23],
            ["id"=>32, "roles_id"=>2,"permissions_id"=>24],
            ["id"=>33, "roles_id"=>2,"permissions_id"=>25],
            ["id"=>34, "roles_id"=>2,"permissions_id"=>26],
            ["id"=>35, "roles_id"=>2,"permissions_id"=>27],
            ["id"=>36, "roles_id"=>3,"permissions_id"=>1],
            ["id"=>37, "roles_id"=>3,"permissions_id"=>2],
            ["id"=>38, "roles_id"=>3,"permissions_id"=>3],
            ["id"=>39, "roles_id"=>3,"permissions_id"=>4],
            ["id"=>40, "roles_id"=>3,"permissions_id"=>5],
            ["id"=>41, "roles_id"=>3,"permissions_id"=>6],
            ["id"=>42, "roles_id"=>3,"permissions_id"=>7],
            ["id"=>43, "roles_id"=>3,"permissions_id"=>8],
            ["id"=>44, "roles_id"=>3,"permissions_id"=>9],
            ["id"=>45, "roles_id"=>3,"permissions_id"=>10],
            
        ];       
        RolePermissions::insert($data);
    }
}
