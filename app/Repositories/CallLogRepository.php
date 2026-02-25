<?php

namespace App\Repositories;

use App\Models\CallLog;
use App\Models\CustomerSubscription;
use App\Models\MinuteUsageSummary;
use App\Repositories\Interfaces\CallLogRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CallLogRepository extends BaseRepository
{
    protected CustomerSubscription $subscriptionModel;
    protected MinuteUsageSummary $summaryModel;

    public function __construct(CallLog $model, CustomerSubscription $subscriptionModel, MinuteUsageSummary $summaryModel)
    {
        parent::__construct($model);
        $this->subscriptionModel = $subscriptionModel;
        $this->summaryModel      = $summaryModel;
    }

    public function paginate(int $perPage = 15, array $filters = [], array $with = [])
    {
        $query = $this->model->with($with ?: ['customer', 'sipConnection']);

        $this->applyFilters($query, $filters);

        return $query->orderByDesc('start_time')->paginate($perPage);
    }

    private function applyFilters($query, array $filters)
    {
        if (!empty($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }
        if (!empty($filters['subscription_id'])) {
            $query->where('customer_subscription_id', $filters['subscription_id']);
        }
        if (!empty($filters['disposition'])) {
            $query->where('disposition', $filters['disposition']);
        }
        if (!empty($filters['call_direction'])) {
            $query->where('call_direction', $filters['call_direction']);
        }
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->forPeriod($filters['start_date'], $filters['end_date']);
        }
        if (!empty($filters['caller_number'])) {
            $query->where('caller_number', 'like', "%{$filters['caller_number']}%");
        }

        return $query;
    }

    public function getByCustomer(int $customerId, array $filters = [])
    {
        $filters['customer_id'] = $customerId;
        return $this->paginate(20, $filters);
    }

    public function getBySubscription(int $subscriptionId, array $filters = [])
    {
        $filters['subscription_id'] = $subscriptionId;
        return $this->paginate(20, $filters);
    }

    public function getStatsByCustomer(int $customerId, string $startDate, string $endDate): array
    {
        $stats = $this->model
            ->where('customer_id', $customerId)
            ->forPeriod($startDate, $endDate)
            ->selectRaw('
                COUNT(*) as total_calls,
                SUM(CASE WHEN disposition = "answered" THEN 1 ELSE 0 END) as answered_calls,
                SUM(billable_minutes) as total_minutes,
                SUM(CASE WHEN call_direction = "inbound" THEN billable_minutes ELSE 0 END) as inbound_minutes,
                SUM(CASE WHEN call_direction = "outbound" THEN billable_minutes ELSE 0 END) as outbound_minutes,
                SUM(CASE WHEN call_direction = "internal" THEN billable_minutes ELSE 0 END) as internal_minutes,
                SUM(CASE WHEN is_in_package = 1 THEN billable_minutes ELSE 0 END) as package_minutes,
                SUM(extra_charge) as total_extra_charge
            ')
            ->first();

        return $stats ? $stats->toArray() : [];
    }

    public function getDailySummary(int $subscriptionId, string $date): array
    {
        return $this->model
            ->where('customer_subscription_id', $subscriptionId)
            ->whereDate('start_time', $date)
            ->selectRaw('
                COUNT(*) as total_calls,
                SUM(CASE WHEN disposition = "answered" THEN 1 ELSE 0 END) as answered_calls,
                SUM(billable_minutes) as total_minutes,
                SUM(CASE WHEN is_in_package = 1 THEN billable_minutes ELSE 0 END) as package_minutes_used,
                SUM(CASE WHEN is_in_package = 0 THEN billable_minutes ELSE 0 END) as extra_minutes_used,
                SUM(extra_charge) as extra_charge
            ')
            ->first()
            ->toArray();
    }

    public function storeCallRecord(array $cdrData)
    {
        return DB::transaction(function () use ($cdrData) {
            // Find the active subscription for this SIP connection
            $subscription = $this->subscriptionModel
                ->where('customer_id', $cdrData['customer_id'])
                ->where('status', 'active')
                ->first();

            if (!$subscription) {
                throw new \Exception("No active subscription found for customer {$cdrData['customer_id']}");
            }

            $billableMinutes = ceil($cdrData['billable_seconds'] / 60);
            $isInPackage = $subscription->remaining_minutes >= $billableMinutes;
            $extraCharge = 0;

            if (!$isInPackage) {
                $extraMinutes = $billableMinutes - max(0, $subscription->remaining_minutes);
                $extraCharge = $extraMinutes * $subscription->servicePackage->extra_minute_price;
            }

            // Create call log
            $callLog = $this->model->create(array_merge($cdrData, [
                'customer_subscription_id' => $subscription->id,
                'is_in_package'            => $isInPackage,
                'extra_charge'             => $extraCharge,
            ]));

            // Update subscription used minutes
            $subscription->increment('used_minutes', $billableMinutes);

            return $callLog;
        });
    }
}
