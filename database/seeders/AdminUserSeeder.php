<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'username'  => 'superadmin',
                'full_name' => 'Nguyễn Văn Hùng',
                'email'     => 'superadmin@vnpt.vn',
                'phone'     => '0912000001',
                'password'  => Hash::make('Admin@123456'),
                'role'      => 'super_admin',
                'status'    => 'active',
            ],
            [
                'username'  => 'admin_kd',
                'full_name' => 'Trần Thị Mai',
                'email'     => 'admin.kd@vnpt.vn',
                'phone'     => '0912000002',
                'password'  => Hash::make('Admin@123456'),
                'role'      => 'admin',
                'status'    => 'active',
            ],
            [
                'username'  => 'operator_01',
                'full_name' => 'Lê Văn Tuấn',
                'email'     => 'operator01@vnpt.vn',
                'phone'     => '0912000003',
                'password'  => Hash::make('Admin@123456'),
                'role'      => 'operator',
                'status'    => 'active',
            ],
            [
                'username'  => 'accountant_01',
                'full_name' => 'Phạm Thị Lan',
                'email'     => 'accountant01@vnpt.vn',
                'phone'     => '0912000004',
                'password'  => Hash::make('Admin@123456'),
                'role'      => 'accountant',
                'status'    => 'active',
            ],
        ];

        foreach ($admins as $admin) {
            AdminUser::updateOrCreate(['email' => $admin['email']], $admin);
        }

        $this->command->info('✅ Admin users seeded: ' . count($admins) . ' records');
    }
}
