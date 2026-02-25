<?php

namespace Database\Seeders;

use App\Models\CallLog;
use App\Models\SipAccount;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CallLogSeeder extends Seeder
{
    private array $vnPhones = [
        '0901111111', '0912222222', '0923333333', '0284567890',
        '02812345678', '0984444444', '0835555555', '0706666666',
    ];

    public function run(): void
    {
        $sipAccounts = SipAccount::with('customer')->get();

        if ($sipAccounts->isEmpty()) {
            $this->command->warn('⚠️  Không có SIP account nào để tạo call log');
            return;
        }

        $count = 0;

        foreach ($sipAccounts as $sipAccount) {
            // Tạo 15-30 cuộc gọi mỗi tài khoản trong 30 ngày qua
            $numCalls = rand(15, 30);

            for ($i = 0; $i < $numCalls; $i++) {
                $this->createCallLog($sipAccount);
                $count++;
            }
        }

        $this->command->info("✅ Call logs seeded: {$count} records");
    }

    private function createCallLog(SipAccount $sipAccount): void
    {
        $isOutbound    = rand(0, 1);
        $startedAt     = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
        $callStatuses  = ['answered', 'answered', 'answered', 'no_answer', 'busy', 'failed'];
        $status        = $callStatuses[array_rand($callStatuses)];
        $callTypes     = ['domestic', 'domestic', 'domestic', 'international', 'internal'];
        $callType      = $callTypes[array_rand($callTypes)];

        $duration      = 0;
        $answeredAt    = null;
        $endedAt       = null;
        $chargeAmount  = 0;

        if ($status === 'answered') {
            $duration   = rand(30, 1800); // 30 giây - 30 phút
            $answeredAt = $startedAt->copy()->addSeconds(rand(3, 15));
            $endedAt    = $answeredAt->copy()->addSeconds($duration);

            // Tính cước đơn giản
            $minutes       = ceil($duration / 60);
            $chargeAmount  = $callType === 'international' ? $minutes * 3000 : max(0, ($minutes - 5) * 700);
        }

        $callerNumber = $sipAccount->sip_username . '@' . $sipAccount->sip_domain;
        $calleeNumber = $this->vnPhones[array_rand($this->vnPhones)];

        if (!$isOutbound) {
            [$callerNumber, $calleeNumber] = [$calleeNumber, $callerNumber];
        }

        CallLog::create([
            'sip_account_id'  => $sipAccount->id,
            'customer_id'     => $sipAccount->customer_id,
            'call_id'         => uniqid('CID-', true),
            'caller_number'   => $callerNumber,
            'callee_number'   => $calleeNumber,
            'direction'       => $isOutbound ? 'outbound' : 'inbound',
            'call_type'       => $callType,
            'status'          => $status,
            'started_at'      => $startedAt,
            'answered_at'     => $answeredAt,
            'ended_at'        => $endedAt,
            'duration_seconds'=> $duration,
            'charge_amount'   => $chargeAmount,
        ]);
    }
}
