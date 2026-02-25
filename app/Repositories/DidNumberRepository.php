<?php

namespace App\Repositories;

use App\Models\DidNumber;
use App\Models\CustomerDidAssignment;
use App\Repositories\Interfaces\DidNumberRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DidNumberRepository extends BaseRepository implements DidNumberRepositoryInterface
{
    protected CustomerDidAssignment $assignmentModel;

    public function __construct(DidNumber $model, CustomerDidAssignment $assignmentModel)
    {
        parent::__construct($model);
        $this->assignmentModel = $assignmentModel;
    }

    public function paginate(int $perPage = 15, array $filters = [], array $with = [])
    {
        $query = $this->model->with($with ?: ['activeAssignment.customer']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['city'])) {
            $query->where('city', 'like', "%{$filters['city']}%");
        }
        if (!empty($filters['search'])) {
            $query->where('number', 'like', "%{$filters['search']}%");
        }

        return $query->latest()->paginate($perPage);
    }

    public function getAvailableNumbers(array $filters = [])
    {
        $query = $this->model->available();

        if (!empty($filters['city'])) {
            $query->where('city', 'like', "%{$filters['city']}%");
        }
        if (!empty($filters['area_code'])) {
            $query->where('area_code', $filters['area_code']);
        }

        return $query->orderBy('number')->get();
    }

    public function getByCustomer(int $customerId)
    {
        return $this->assignmentModel
                    ->where('customer_id', $customerId)
                    ->where('status', 'active')
                    ->with(['didNumber', 'sipConnection'])
                    ->get();
    }

    public function assignToCustomer(int $didId, array $assignmentData)
    {
        return DB::transaction(function () use ($didId, $assignmentData) {
            $this->model->where('id', $didId)->update(['status' => 'assigned']);
            return $this->assignmentModel->create(array_merge($assignmentData, [
                'did_number_id' => $didId,
                'status' => 'active',
            ]));
        });
    }

    public function releaseNumber(int $assignmentId): bool
    {
        return DB::transaction(function () use ($assignmentId) {
            $assignment = $this->assignmentModel->findOrFail($assignmentId);
            $this->model->where('id', $assignment->did_number_id)->update(['status' => 'available']);
            return $assignment->update(['status' => 'released']);
        });
    }
}
