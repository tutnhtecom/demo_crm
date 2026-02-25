<?php

namespace App\Services;

use App\Models\SipAccount;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SipProvisioningService {
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.vnpt_sip.base_url', 'http://sip.vnpt.vn/api');
        $this->apiKey  = config('services.vnpt_sip.api_key', '');
    }

    /**
     * Kích hoạt dịch vụ VoIP trên VNPT SIP Server
     * Tạo SIP Account trong DB và gửi lệnh kích hoạt lên SIP Server
     */
    public function activate(Subscription $subscription): bool
    {
        try {
            $package  = $subscription->package;
            $customer = $subscription->customer;

            // Tạo SIP Account trong CRM DB
            $sipAccount = SipAccount::create([
                'customer_id'     => $customer->id,
                'subscription_id' => $subscription->id,
                'sip_username'    => $this->generateSipUsername($customer->phone),
                'sip_password'    => $this->generateSipPassword(),
                'sip_domain'      => config('services.vnpt_sip.domain', 'sip.vnpt.vn'),
                'display_name'    => $customer->full_name,
                'status'          => 'active',
            ]);

            // Gửi lệnh kích hoạt lên VNPT SIP Server
            $response = $this->callSipApi('POST', '/accounts/create', [
                'username'        => $sipAccount->sip_username,
                'password'        => $sipAccount->sip_password,
                'display_name'    => $sipAccount->display_name,
                'max_calls'       => $package->concurrent_call_limit,
                'free_minutes'    => $package->free_minutes_domestic,
                'plan_code'       => $package->code,
            ]);

            if ($response && $response['success']) {
                $sipAccount->update([
                    'did_number' => $response['data']['did_number'] ?? null,
                    'caller_id'  => $response['data']['caller_id'] ?? $sipAccount->sip_username,
                ]);

                Log::info('[SIP] Kích hoạt thành công', [
                    'subscription_id' => $subscription->id,
                    'sip_username'    => $sipAccount->sip_username,
                ]);
                return true;
            }

            Log::error('[SIP] Kích hoạt thất bại', ['response' => $response]);
            return false;

        } catch (\Exception $e) {
            Log::error('[SIP] Lỗi khi kích hoạt', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Tạm dừng tất cả SIP Accounts của subscription trên SIP Server
     */
    public function suspend(Subscription $subscription): bool
    {
        try {
            $sipAccounts = SipAccount::where('subscription_id', $subscription->id)
                ->where('status', 'active')
                ->get();

            foreach ($sipAccounts as $account) {
                $this->callSipApi('POST', '/accounts/suspend', [
                    'username' => $account->sip_username,
                ]);

                $account->update(['status' => 'suspended']);
            }

            Log::info('[SIP] Đã tạm dừng', ['subscription_id' => $subscription->id]);
            return true;

        } catch (\Exception $e) {
            Log::error('[SIP] Lỗi khi tạm dừng', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Chấm dứt dịch vụ - xóa SIP Account trên server
     */
    public function terminate(Subscription $subscription): bool
    {
        try {
            $sipAccounts = SipAccount::where('subscription_id', $subscription->id)->get();

            foreach ($sipAccounts as $account) {
                $this->callSipApi('DELETE', '/accounts/' . $account->sip_username);
                $account->update(['status' => 'terminated']);
            }

            return true;

        } catch (\Exception $e) {
            Log::error('[SIP] Lỗi khi chấm dứt', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Cập nhật cấu hình SIP khi nâng cấp gói
     */
    public function updateConfig(Subscription $subscription): bool
    {
        try {
            $package     = $subscription->package;
            $sipAccounts = SipAccount::where('subscription_id', $subscription->id)->get();

            foreach ($sipAccounts as $account) {
                $this->callSipApi('PUT', '/accounts/' . $account->sip_username, [
                    'max_calls'    => $package->concurrent_call_limit,
                    'free_minutes' => $package->free_minutes_domestic,
                    'plan_code'    => $package->code,
                ]);
            }

            return true;

        } catch (\Exception $e) {
            Log::error('[SIP] Lỗi khi cập nhật cấu hình', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Đồng bộ trạng thái thực tế từ SIP Server về CRM
     */
    public function syncStatus(Subscription $subscription): array
    {
        $results = [];
        $sipAccounts = SipAccount::where('subscription_id', $subscription->id)->get();

        foreach ($sipAccounts as $account) {
            $response = $this->callSipApi('GET', '/accounts/' . $account->sip_username . '/status');

            if ($response && isset($response['data'])) {
                $registrationStatus = $response['data']['registered'] ? 'registered' : 'unregistered';
                $account->update([
                    'registration_status' => $registrationStatus,
                    'last_registered_ip'  => $response['data']['last_ip'] ?? null,
                    'last_registered_at'  => $response['data']['last_seen'] ?? null,
                ]);
            }

            $results[$account->sip_username] = $response;
        }

        return $results;
    }

    // ─── Private helpers ─────────────────────────────────────────────

    private function callSipApi(string $method, string $endpoint, array $payload = []): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept'        => 'application/json',
            ])->timeout(10)->{strtolower($method)}($this->baseUrl . $endpoint, $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('[SIP API] Non-2xx response', [
                'endpoint' => $endpoint,
                'status'   => $response->status(),
                'body'     => $response->body(),
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('[SIP API] Request failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function generateSipUsername(string $phone): string
    {
        return 'sip_' . ltrim($phone, '0') . '_' . Str::random(4);
    }

    private function generateSipPassword(): string
    {
        return Str::password(16, symbols: false);
    }
}