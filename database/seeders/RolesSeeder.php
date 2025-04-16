<?php

namespace Database\Seeders;

use App\Models\Roles;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::insert([
            ["name"  =>  "Admin", "slug" => "Admin", "created_at" => Carbon::now(), "created_by" => Auth::user()->id ?? 1], 
            ["name"  =>  "Sale Leader", "slug" => "Sale_Leader", "created_at" => Carbon::now(), "created_by" => Auth::user()->id ?? 1], 
            ["name"  =>  "Tư vấn viên", "slug" => "tu_van_vien", "created_at" => Carbon::now(), "created_by" => Auth::user()->id ?? 1]
        ]);
    }
}
