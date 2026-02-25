<?php

namespace App\Repositories;

use App\Models\ServicePackage;
use App\Repositories\Interfaces\ServicePackageRepositoryInterface;

class ServicePackageRepository extends BaseRepository implements ServicePackageRepositoryInterface
{
    public function __construct(ServicePackage $model)
    {
        parent::__construct($model);
    }

    public function all(array $filters = [], array $with = [])
    {
        $query = $this->model->with($with);

        if (!empty($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }
        if (!empty($filters['call_type'])) {
            $query->where('call_type', $filters['call_type']);
        }

        return $query->orderBy('price_monthly')->get();
    }

    public function paginate(int $perPage = 15, array $filters = [], array $with = [])
    {
        $query = $this->model->with($with);

        if (isset($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('code', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('price_monthly')->paginate($perPage);
    }

    public function getActivePackages()
    {
        return $this->model->active()->orderBy('price_monthly')->get();
    }

    public function findByCode(string $code)
    {
        return $this->model->where('code', $code)->firstOrFail();
    }
}
