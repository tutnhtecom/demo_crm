<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class CustomerRepository extends BaseRepository 
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    public function paginateWithFilters(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['customer_type'])) {
            $query->where('customer_type', $filters['customer_type']);
        }

        if (!empty($filters['province'])) {
            $query->where('province', $filters['province']);
        }

        $sortBy    = $filters['sort_by']    ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    public function findByEmail(string $email): ?Model
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByPhone(string $phone): ?Model
    {
        return $this->model->where('phone', $phone)->first();
    }

    public function findByCode(string $code): ?Model
    {
        return $this->model->where('code', $code)->first();
    }

    public function updateBalance(int $customerId, float $amount): Model
    {
        $customer = $this->findOrFail($customerId);
        $customer->increment('balance', $amount);
        return $customer->fresh();
    }

    public function getWithActiveSubscription(int $customerId): ?Model
    {
        return $this->model
            ->with(['activeSubscription.package', 'sipAccounts' => fn($q) => $q->active()])
            ->find($customerId);
    }
}