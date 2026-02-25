<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Thứ tự quan trọng do ràng buộc khóa ngoại:
     * 1. AdminUsers      (không phụ thuộc)
     * 2. Packages        (không phụ thuộc)
     * 3. Customers       (không phụ thuộc)
     * 4. Subscriptions   (phụ thuộc customers, packages, admin_users)
     * 5. SipAccounts     (được tạo trong SubscriptionSeeder)
     * 6. Invoices        (phụ thuộc customers, subscriptions)
     * 7. Payments        (phụ thuộc customers, invoices, admin_users)
     * 8. CallLogs        (phụ thuộc sip_accounts, customers)
     */
    public function run(): void
    {
        $this->command->info('🚀 Bắt đầu seed dữ liệu VNPT Voice IP CRM...');
        $this->command->newLine();

        $this->call([
            AdminUserSeeder::class,
            PackageSeeder::class,
            CustomerSeeder::class,
            SubscriptionSeeder::class,
            InvoicePaymentSeeder::class,
            CallLogSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('🎉 Seed dữ liệu hoàn tất!');
        $this->command->newLine();
        $this->command->table(
            ['Đối tượng', 'Tài khoản test'],
            [
                ['Admin (Super Admin)', 'superadmin@vnpt.vn / Admin@123456'],
                ['Admin (Kế toán)',     'accountant01@vnpt.vn / Admin@123456'],
                ['Khách hàng cá nhân', 'nguyenvanan@gmail.com / Customer@123'],
                ['Khách hàng DN',      'info@techsolutionvn.com / Customer@123'],
            ]
        );
    }
}
