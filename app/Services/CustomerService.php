<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerService
{
    protected $customerRepository;
    public function __construct(CustomerRepository $customerRepository) {
         $this->customerRepository = $customerRepository;
    }

    public function list(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->customerRepository->paginateWithFilters($filters, $perPage);
    }

    public function show(int $id): Model
    {
        return $this->customerRepository->findOrFail($id);
    }

    public function create(array $data): Model
    {
        // Check email uniqueness
        if ($this->customerRepository->findByEmail($data['email'])) {
            throw ValidationException::withMessages(['email' => ['Email đã tồn tại trong hệ thống.']]);
        }

        // Check phone uniqueness
        if ($this->customerRepository->findByPhone($data['phone'])) {
            throw ValidationException::withMessages(['phone' => ['Số điện thoại đã tồn tại trong hệ thống.']]);
        }

        return DB::transaction(function () use ($data) {
            $data['code']     = $this->generateCustomerCode();
            $data['password'] = Hash::make($data['password']);

            return $this->customerRepository->create($data);
        });
    }

    public function update(int $id, array $data): Model
    {
        $customer = $this->customerRepository->findOrFail($id);

        // Check email uniqueness (exclude current customer)
        if (!empty($data['email']) && $data['email'] !== $customer->email) {
            $existing = $this->customerRepository->findByEmail($data['email']);
            if ($existing && $existing->id !== $id) {
                throw ValidationException::withMessages(['email' => ['Email đã tồn tại trong hệ thống.']]);
            }
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $this->customerRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $customer = $this->customerRepository->findOrFail($id);

        // Check if customer has active subscriptions
        $activeSubscriptions = $customer->subscriptions()->where('status', 'active')->count();
        if ($activeSubscriptions > 0) {
            throw new \RuntimeException('Không thể xóa khách hàng đang có gói cước hoạt động.');
        }

        return $this->customerRepository->delete($id);
    }

    public function changeStatus(int $id, string $status): Model
    {
        $allowedStatuses = ['active', 'inactive', 'locked'];

        if (!in_array($status, $allowedStatuses)) {
            throw new \InvalidArgumentException("Trạng thái không hợp lệ: {$status}");
        }

        return $this->customerRepository->update($id, ['status' => $status]);
    }

    public function getProfile(int $customerId): Model
    {
        return $this->customerRepository->getWithActiveSubscription($customerId);
    }

    private function generateCustomerCode(): string
    {
        $prefix  = 'KH';
        $year    = date('Y');
        $lastCode = \App\Models\Customer::withTrashed()
            ->where('code', 'like', "{$prefix}{$year}%")
            ->orderByDesc('code')
            ->value('code');

        if ($lastCode) {
            $sequence = (int) substr($lastCode, -5) + 1;
        } else {
            $sequence = 1;
        }

        return $prefix . $year . str_pad($sequence, 5, '0', STR_PAD_LEFT);
    }
}