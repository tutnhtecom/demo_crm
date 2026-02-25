<?php

namespace App\Repositories;

use App\Models\Subscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionRepository extends BaseRepository 
{
    public function __construct(Subscription $model)
    {
        parent::__construct($model);
    }

    public function paginateWithFilters(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with(['customer', 'package']);

        if (!empty($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (!empty($filters['package_id'])) {
            $query->where('package_id', $filters['package_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['billing_cycle'])) {
            $query->where('billing_cycle', $filters['billing_cycle']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('start_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('end_date', '<=', $filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getActiveByCustomer(int $customerId): Collection
    {
        return $this->model
            ->with('package')
            ->where('customer_id', $customerId)
            ->where('status', 'active')
            ->get();
    }

    public function getExpiringSoon(int $days = 7): Collection
    {
        return $this->model
            ->with(['customer', 'package'])
            ->expiringSoon($days)
            ->get();
    }

    public function getDueForBilling(): Collection
    {
        return $this->model
            ->with(['customer', 'package'])
            ->where('status', 'active')
            ->where('auto_renew', true)
            ->whereDate('next_billing_date', '<=', now())
            ->get();
    }
}