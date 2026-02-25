<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Package;
use App\Models\SipAccount;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $adminId  = 1; // superadmin
        $packages = Package::pluck('id', 'code');

        $subscriptions = [
            // KH 1 - Gói Basic, active
            [
                'customer_email' => 'nguyenvanan@gmail.com',
                'package_code'   => 'VOIP-BASIC',
                'billing_cycle'  => 'monthly',
                'status'         => 'active',
                'start_offset'   => -20, // started 20 days ago
                'end_offset'     => 10,  // ends in 10 days
            ],
            // KH 2 - Gói Standard, active
            [
                'customer_email' => 'tranthibich@yahoo.com',
                'package_code'   => 'VOIP-STD',
                'billing_cycle'  => 'monthly',
                'status'         => 'active',
                'start_offset'   => -15,
                'end_offset'     => 15,
            ],
            // KH 4 - Doanh nghiệp, Gói Premium, active
            [
                'customer_email' => 'info@techsolutionvn.com',
                'package_code'   => 'VOIP-PRO',
                'billing_cycle'  => 'yearly',
                'status'         => 'active',
                'start_offset'   => -60,
                'end_offset'     => 305,
            ],
            // KH 5 - Gói Standard, hết hạn
            [
                'customer_email' => 'contact@hoanganh-trading.vn',
                'package_code'   => 'VOIP-STD',
                'billing_cycle'  => 'monthly',
                'status'         => 'expired',
                'start_offset'   => -60,
                'end_offset'     => -30,
            ],
            // KH 6 - Gói Basic, active, sắp hết hạn (5 ngày)
            [
                'customer_email' => 'vothiphuong@gmail.com',
                'package_code'   => 'VOIP-BASIC',
                'billing_cycle'  => 'monthly',
                'status'         => 'active',
                'start_offset'   => -25,
                'end_offset'     => 5,
            ],
            // KH 8 - Doanh nghiệp lớn, Enterprise
            [
                'customer_email' => 'admin@hoaphatgroup.vn',
                'package_code'   => 'VOIP-ENT',
                'billing_cycle'  => 'yearly',
                'status'         => 'active',
                'start_offset'   => -90,
                'end_offset'     => 275,
            ],
        ];

        foreach ($subscriptions as $data) {
            $customer = Customer::where('email', $data['customer_email'])->first();
            if (!$customer) {
                continue;
            }

            $packageId = $packages[$data['package_code']] ?? null;
            if (!$packageId) {
                continue;
            }

            $package   = Package::find($packageId);
            $startDate = Carbon::now()->addDays($data['start_offset']);
            $endDate   = Carbon::now()->addDays($data['end_offset']);
            $price     = $data['billing_cycle'] === 'yearly' ? $package->price_yearly : $package->price_monthly;

            $subscription = Subscription::updateOrCreate(
                ['customer_id' => $customer->id, 'package_id' => $packageId],
                [
                    'code'                  => 'SUB-' . strtoupper(uniqid()),
                    'customer_id'           => $customer->id,
                    'package_id'            => $packageId,
                    'created_by'            => $adminId,
                    'billing_cycle'         => $data['billing_cycle'],
                    'price_at_subscription' => $price,
                    'start_date'            => $startDate->toDateString(),
                    'end_date'              => $endDate->toDateString(),
                    'next_billing_date'     => $endDate->toDateString(),
                    'status'                => $data['status'],
                    'auto_renew'            => true,
                ]
            );

            // Tạo SIP Account cho gói active
            if ($data['status'] === 'active') {
                $this->createSipAccount($customer, $subscription, $package);
            }
        }

        $this->command->info('✅ Subscriptions seeded: ' . count($subscriptions) . ' records');
    }

    private function createSipAccount(Customer $customer, Subscription $subscription, Package $package): void
    {
        $phone    = ltrim($customer->phone, '0');
        $username = 'sip_' . $phone;

        SipAccount::updateOrCreate(
            ['sip_username' => $username],
            [
                'customer_id'         => $customer->id,
                'subscription_id'     => $subscription->id,
                'sip_username'        => $username,
                'sip_password'        => bcrypt('SipPass@' . substr($phone, -4)),
                'sip_domain'          => 'sip.vnpt.vn',
                'display_name'        => $customer->full_name,
                'did_number'          => '028' . rand(10000000, 99999999),
                'caller_id'           => $username . '@sip.vnpt.vn',
                'status'              => 'active',
                'registration_status' => rand(0, 1) ? 'registered' : 'unregistered',
                'last_registered_ip'  => '14.191.' . rand(1, 255) . '.' . rand(1, 255),
                'last_registered_at'  => Carbon::now()->subHours(rand(0, 24)),
            ]
        );
    }
}
