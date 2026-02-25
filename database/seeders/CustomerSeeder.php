<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            // Khách hàng cá nhân
            [
                'code'          => 'KH2024000001',
                'full_name'     => 'Nguyễn Văn An',
                'email'         => 'nguyenvanan@gmail.com',
                'phone'         => '0901234567',
                'id_card'       => '031090001234',
                'address'       => '123 Đường Lê Lợi, Phường Bến Nghé',
                'province'      => 'TP. Hồ Chí Minh',
                'customer_type' => 'individual',
                'balance'       => 500000,
                'status'        => 'active',
                'password'      => Hash::make('Customer@123'),
            ],
            [
                'code'          => 'KH2024000002',
                'full_name'     => 'Trần Thị Bích',
                'email'         => 'tranthibich@yahoo.com',
                'phone'         => '0912345678',
                'id_card'       => '026085002345',
                'address'       => '45 Hoàn Kiếm, Quận Hoàn Kiếm',
                'province'      => 'Hà Nội',
                'customer_type' => 'individual',
                'balance'       => 200000,
                'status'        => 'active',
                'password'      => Hash::make('Customer@123'),
            ],
            [
                'code'          => 'KH2024000003',
                'full_name'     => 'Lê Quốc Cường',
                'email'         => 'lequoccuong@outlook.com',
                'phone'         => '0987654321',
                'id_card'       => '064091003456',
                'address'       => '78 Nguyễn Huệ, TP. Đà Nẵng',
                'province'      => 'Đà Nẵng',
                'customer_type' => 'individual',
                'balance'       => 0,
                'status'        => 'inactive',
                'password'      => Hash::make('Customer@123'),
            ],
            // Khách hàng doanh nghiệp
            [
                'code'          => 'KH2024000004',
                'full_name'     => 'Phạm Minh Đức',
                'email'         => 'info@techsolutionvn.com',
                'phone'         => '0903456789',
                'address'       => 'Tòa nhà Bitexco, 02 Hải Triều, Quận 1',
                'province'      => 'TP. Hồ Chí Minh',
                'customer_type' => 'business',
                'company_name'  => 'Công ty TNHH Tech Solution Việt Nam',
                'tax_code'      => '0312345678',
                'balance'       => 5000000,
                'status'        => 'active',
                'password'      => Hash::make('Customer@123'),
            ],
            [
                'code'          => 'KH2024000005',
                'full_name'     => 'Hoàng Văn Em',
                'email'         => 'contact@hoanganh-trading.vn',
                'phone'         => '0934567890',
                'address'       => '15 Đinh Tiên Hoàng, Quận Bình Thạnh',
                'province'      => 'TP. Hồ Chí Minh',
                'customer_type' => 'business',
                'company_name'  => 'Công ty CP Thương mại Hoàng Anh',
                'tax_code'      => '0387654321',
                'balance'       => 2000000,
                'status'        => 'active',
                'password'      => Hash::make('Customer@123'),
            ],
            [
                'code'          => 'KH2024000006',
                'full_name'     => 'Võ Thị Phương',
                'email'         => 'vothiphuong@gmail.com',
                'phone'         => '0945678901',
                'id_card'       => '070093006789',
                'address'       => '99 Trần Hưng Đạo, TP. Cần Thơ',
                'province'      => 'Cần Thơ',
                'customer_type' => 'individual',
                'balance'       => 150000,
                'status'        => 'active',
                'password'      => Hash::make('Customer@123'),
            ],
            [
                'code'          => 'KH2024000007',
                'full_name'     => 'Đỗ Hữu Giang',
                'email'         => 'dohugiang@vnpt.vn',
                'phone'         => '0956789012',
                'id_card'       => '038088007890',
                'address'       => '22 Lý Thái Tổ, Quận Đống Đa',
                'province'      => 'Hà Nội',
                'customer_type' => 'individual',
                'balance'       => 350000,
                'status'        => 'locked',
                'password'      => Hash::make('Customer@123'),
            ],
            [
                'code'          => 'KH2024000008',
                'full_name'     => 'Bùi Thị Hoa',
                'email'         => 'admin@hoaphatgroup.vn',
                'phone'         => '0967890123',
                'address'       => 'KCN Phố Nối A, Mỹ Hào, Hưng Yên',
                'province'      => 'Hưng Yên',
                'customer_type' => 'business',
                'company_name'  => 'Công ty TNHH Hoa Phát Group',
                'tax_code'      => '0901234567',
                'balance'       => 10000000,
                'status'        => 'active',
                'password'      => Hash::make('Customer@123'),
            ],
        ];

        foreach ($customers as $customer) {
            Customer::updateOrCreate(['email' => $customer['email']], $customer);
        }

        $this->command->info('✅ Customers seeded: ' . count($customers) . ' records');
    }
}
