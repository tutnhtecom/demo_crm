<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Services\CustomerService;
use App\Services\Interfaces\CustomerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CustomerController extends BaseApiController
{
    protected $customerService;
    public function __construct(CustomerService $customerService) {
        $this->customerService = $customerService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->only([
                'search', 'status', 'customer_type', 'province',
                'sort_by', 'sort_order',
            ]);

            $perPage = (int) $request->get('per_page', 15);
            $result  = $this->customerService->list($filters, $perPage);

            return $this->paginated($result, 'Lấy danh sách khách hàng thành công');

        } catch (\Exception $e) {
            return $this->error('Lỗi khi lấy danh sách khách hàng: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Chi tiết khách hàng
     */
    public function show(int $id): JsonResponse
    {
        try {
            $customer = $this->customerService->show($id);
            return $this->success($customer, 'Lấy thông tin khách hàng thành công');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Không tìm thấy khách hàng');
        } catch (\Exception $e) {
            return $this->error('Lỗi khi lấy thông tin khách hàng', null, 500);
        }
    }

    /**
     * Tạo mới khách hàng
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        try {
            $customer = $this->customerService->create($request->validated());
            return $this->created($customer, 'Tạo khách hàng thành công');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Dữ liệu không hợp lệ', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->error('Lỗi khi tạo khách hàng: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Cập nhật thông tin khách hàng
     */
    public function update(UpdateCustomerRequest $request, int $id): JsonResponse
    {
        try {
            $customer = $this->customerService->update($id, $request->validated());
            return $this->success($customer, 'Cập nhật khách hàng thành công');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Không tìm thấy khách hàng');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Dữ liệu không hợp lệ', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->error('Lỗi khi cập nhật khách hàng: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Xóa khách hàng (soft delete)
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->customerService->delete($id);
            return $this->success(null, 'Xóa khách hàng thành công');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Không tìm thấy khách hàng');
        } catch (\RuntimeException $e) {
            return $this->error($e->getMessage(), null, 409);
        } catch (\Exception $e) {
            return $this->error('Lỗi khi xóa khách hàng: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Thay đổi trạng thái khách hàng
     */
    public function changeStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:active,inactive,locked',
        ]);

        try {
            $customer = $this->customerService->changeStatus($id, $request->status);
            return $this->success($customer, 'Cập nhật trạng thái thành công');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Không tìm thấy khách hàng');
        } catch (\Exception $e) {
            return $this->error('Lỗi khi thay đổi trạng thái: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Thông tin profile (dùng cho portal khách hàng)
     */
    public function profile(Request $request): JsonResponse
    {
        try {
            $customerId = $request->user()->id;
            $profile    = $this->customerService->getProfile($customerId);
            return $this->success($profile, 'Lấy thông tin profile thành công');

        } catch (\Exception $e) {
            return $this->error('Lỗi khi lấy profile: ' . $e->getMessage(), null, 500);
        }
    }
}