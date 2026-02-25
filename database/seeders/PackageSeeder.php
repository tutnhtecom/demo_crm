<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'code'                          => 'VOIP-BASIC',
                'name'                          => 'Gói Cơ bản',
                'description'                   => 'Gói VoIP cơ bản dành cho cá nhân và hộ gia đình với 1 số điện thoại VoIP.',
                'type'                          => 'basic',
                'price_monthly'                 => 99000,
                'price_yearly'                  => 990000,
                'sip_account_limit'             => 1,
                'concurrent_call_limit'         => 1,
                'free_minutes_domestic'         => 100,
                'free_minutes_international'    => 0,
                'rate_per_minute_domestic'      => 850,
                'rate_per_minute_international' => 3500,
                'storage_gb'                    => 1,
                'features'                      => ['Gọi nội tỉnh', 'Nhận cuộc gọi', 'Voicemail'],
                'status'                        => 'active',
                'sort_order'                    => 1,
            ],
            [
                'code'                          => 'VOIP-STD',
                'name'                          => 'Gói Tiêu chuẩn',
                'description'                   => 'Gói VoIP tiêu chuẩn dành cho hộ kinh doanh nhỏ với 3 số điện thoại VoIP.',
                'type'                          => 'standard',
                'price_monthly'                 => 299000,
                'price_yearly'                  => 2990000,
                'sip_account_limit'             => 3,
                'concurrent_call_limit'         => 3,
                'free_minutes_domestic'         => 500,
                'free_minutes_international'    => 30,
                'rate_per_minute_domestic'      => 700,
                'rate_per_minute_international' => 3000,
                'storage_gb'                    => 5,
                'features'                      => ['Gọi nội tỉnh', 'Gọi liên tỉnh', 'Số DID', 'Voicemail', 'Chuyển cuộc gọi', 'IVR cơ bản'],
                'status'                        => 'active',
                'sort_order'                    => 2,
            ],
            [
                'code'                          => 'VOIP-PRO',
                'name'                          => 'Gói Chuyên nghiệp',
                'description'                   => 'Gói VoIP cao cấp cho doanh nghiệp vừa với đầy đủ tính năng tổng đài.',
                'type'                          => 'premium',
                'price_monthly'                 => 799000,
                'price_yearly'                  => 7990000,
                'sip_account_limit'             => 10,
                'concurrent_call_limit'         => 10,
                'free_minutes_domestic'         => 2000,
                'free_minutes_international'    => 100,
                'rate_per_minute_domestic'      => 500,
                'rate_per_minute_international' => 2500,
                'storage_gb'                    => 20,
                'features'                      => [
                    'Gọi nội/liên tỉnh', 'Gọi quốc tế',
                    'Số DID đa kênh', 'Tổng đài IVR',
                    'Ghi âm cuộc gọi', 'Queue cuộc gọi',
                    'Báo cáo chi tiết', 'API tích hợp',
                ],
                'status'                        => 'active',
                'sort_order'                    => 3,
            ],
            [
                'code'                          => 'VOIP-ENT',
                'name'                          => 'Gói Doanh nghiệp',
                'description'                   => 'Giải pháp VoIP toàn diện cho doanh nghiệp lớn, không giới hạn số lượng máy nhánh.',
                'type'                          => 'enterprise',
                'price_monthly'                 => 2999000,
                'price_yearly'                  => 29990000,
                'sip_account_limit'             => 50,
                'concurrent_call_limit'         => 50,
                'free_minutes_domestic'         => 10000,
                'free_minutes_international'    => 500,
                'rate_per_minute_domestic'      => 300,
                'rate_per_minute_international' => 2000,
                'storage_gb'                    => 100,
                'features'                      => [
                    'Tất cả tính năng Premium',
                    'Dedicated SIP Trunk',
                    'SLA 99.9% uptime',
                    'Hỗ trợ 24/7',
                    'Tùy chỉnh theo yêu cầu',
                    'Multi-site support',
                    'Advanced analytics',
                    'CRM integration',
                ],
                'status'                        => 'active',
                'sort_order'                    => 4,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(['code' => $pkg['code']], $pkg);
        }

        $this->command->info('✅ Packages seeded: ' . count($packages) . ' records');
    }
}
