<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        $model = User::where('id', 1 )->where('email', '!=' ,'admin@htecom.vn')->first();
        if(!isset($model->id)) {
            // $model = $model->update(['id' =>  rand(100, 999)]);
            $data =  [
                'id'                => 1,            
                'email'             => 'admin@htecom.vn',            
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'status'            => User::ACTIVE,
                'types'             => User::TYPE_EMPLOYEES
            ];        
            User::insert($data);
        }
    }
}
