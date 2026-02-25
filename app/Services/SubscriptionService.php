<?php

namespace App\Services;

use App\Models\Package;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;
use App\Repositories\SubscriptionRepository;
use App\Services\Interfaces\SubscriptionServiceInterface;
use App\Services\Interfaces\SipProvisioningServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubscriptionService 
{
    protected $subscriptionRepository;
    public function __construct(SubscriptionRepository  $subscriptionRepository) {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function list(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->subscriptionRepository->paginateWithFilters($filters, $perPage);
    }

    public function show(int $id): Model
    {
        return $this->subscriptionRepository->findOrFail($id);
    }

    /**
     * Đăng ký gói cước mới cho khách hàng
     * Luồng: Tạo Subscription → Tạo SIP Account → Kích hoạt trên SIP Server
     */
    public function register(array $data, int $adminId): Model
    {
        $package = Package::findOrFail($data['package_id']);

        return DB::transaction(function () use ($data, $package, $adminId) {
            $billingCycle = $data['billing_cycle'] ?? 'monthly';
            $price        = $billingCycle === 'yearly' ? $package->price_yearly : $package->price_monthly;
            $startDate    = now()->toDateString();
            $endDate      = $billingCycle === 'yearly'
                ? now()->addYear()->toDateString()
                : now()->addMonth()->toDateString();

            // 1. Tạo subscription
            $subscription = $this->subscriptionRepository->create([
                'code'                   => $this->generateSubscriptionCode(),
                'customer_id'            => $data['customer_id'],
                'package_id'             => $data['package_id'],
                'created_by'             => $adminId,
                'billing_cycle'          => $billingCycle,
                'price_at_subscription'  => $price,
                'start_date'             => $startDate,
                'end_date'               => $endDate,
                'next_billing_date'      => $endDate,
                'status'                 => 'active',
                'auto_renew'             => $data['auto_renew'] ?? true,
                'notes'                  => $data['notes'] ?? null,
            ]);

            // 2. Kích hoạt dịch vụ trên SIP Server (Service Provisioning)
            $this->sipProvisioning->activate($subscription);

            return $subscription->load(['customer', 'package']);
        });
    }

    public function cancel(int $id, string $reason, int $adminId): Model
    {
        return DB::transaction(function () use ($id, $reason, $adminId) {
            $subscription = $this->subscriptionRepository->update($id, [
                'status'        => 'cancelled',
                'cancel_reason' => $reason,
                'cancelled_at'  => now(),
                'cancelled_by'  => $adminId,
            ]);

            // Tạm dừng tất cả SIP accounts liên quan
            $this->sipProvisioning->suspend($subscription);

            return $subscription;
        });
    }

    public function renew(int $id, int $adminId): Model
    {
        $subscription = $this->subscriptionRepository->findOrFail($id);
        $billingCycle = $subscription->billing_cycle;

        $newEndDate = $billingCycle === 'yearly'
            ? $subscription->end_date->addYear()
            : $subscription->end_date->addMonth();

        return $this->subscriptionRepository->update($id, [
            'status'            => 'active',
            'end_date'          => $newEndDate->toDateString(),
            'next_billing_date' => $newEndDate->toDateString(),
        ]);
    }

    public function upgrade(int $id, int $newPackageId, int $adminId): Model
    {
        $newPackage = Package::findOrFail($newPackageId);

        return DB::transaction(function () use ($id, $newPackage, $adminId) {
            $subscription = $this->subscriptionRepository->update($id, [
                'package_id'            => $newPackage->id,
                'price_at_subscription' => $newPackage->price_monthly,
            ]);

            // Cập nhật cấu hình SIP theo gói mới
            $this->sipProvisioning->updateConfig($subscription);

            return $subscription->load('package');
        });
    }

    public function suspend(int $id): Model
    {
        $subscription = $this->subscriptionRepository->update($id, ['status' => 'suspended']);
        $this->sipProvisioning->suspend($subscription);
        return $subscription;
    }

    public function activate(int $id): Model
    {
        $subscription = $this->subscriptionRepository->update($id, ['status' => 'active']);
        $this->sipProvisioning->activate($subscription);
        return $subscription;
    }

    private function generateSubscriptionCode(): string
    {
        return 'SUB-' . strtoupper(uniqid()) . '-' . now()->format('ymd');
    }
}