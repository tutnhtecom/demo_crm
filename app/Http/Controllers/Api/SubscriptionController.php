<?php

namespace App\Http\Controllers\Api;

use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Quản lý Đăng ký Gói cước
 */
class SubscriptionController extends BaseApiController
{
    protected $subscriptionService;
    public function __construct(SubscriptionService $subscriptionService
    ) {
        $this->subscriptionService = $subscriptionService;        
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->only([
                'customer_id', 'package_id', 'status', 'billing_cycle',
                'date_from', 'date_to',
            ]);

            $result = $this->subscriptionService->list($filters, (int) $request->get('per_page', 15));
            return $this->paginated($result, 'Lấy danh sách đăng ký thành công');

        } catch (\Exception $e) {
            return $this->error('Lỗi: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Chi tiết đăng ký gói
     */
    public function show(int $id): JsonResponse
    {
        try {
            $subscription = $this->subscriptionService->show($id);
            return $this->success($subscription, 'Lấy thông tin đăng ký thành công');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->notFound('Không tìm thấy đăng ký');
        }
    }

    /**
     * Đăng ký gói cước mới
     * Luồng: Tạo Subscription → Tạo SIP Account → Kích hoạt SIP Server
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'customer_id'   => 'required|integer|exists:customers,id',
            'package_id'    => 'required|integer|exists:packages,id',
            'billing_cycle' => 'nullable|in:monthly,yearly',
            'auto_renew'    => 'nullable|boolean',
            'notes'         => 'nullable|string|max:500',
        ]);

        try {
            $subscription = $this->subscriptionService->register(
                $request->validated(),
                $request->user()->id
            );
            return $this->created($subscription, 'Đăng ký gói cước thành công');

        } catch (\Exception $e) {
            return $this->error('Lỗi khi đăng ký gói: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Hủy đăng ký gói cước
     */
    public function cancel(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        try {
            $subscription = $this->subscriptionService->cancel(
                $id,
                $request->reason,
                $request->user()->id
            );
            return $this->success($subscription, 'Hủy gói cước thành công');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->notFound('Không tìm thấy đăng ký');
        } catch (\Exception $e) {
            return $this->error('Lỗi khi hủy gói: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Gia hạn gói cước
     */
    public function renew(Request $request, int $id): JsonResponse
    {
        try {
            $subscription = $this->subscriptionService->renew($id, $request->user()->id);
            return $this->success($subscription, 'Gia hạn gói cước thành công');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->notFound('Không tìm thấy đăng ký');
        } catch (\Exception $e) {
            return $this->error('Lỗi khi gia hạn: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Nâng cấp gói cước
     */
    public function upgrade(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'package_id' => 'required|integer|exists:packages,id',
        ]);

        try {
            $subscription = $this->subscriptionService->upgrade(
                $id,
                $request->package_id,
                $request->user()->id
            );
            return $this->success($subscription, 'Nâng cấp gói cước thành công');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->notFound('Không tìm thấy đăng ký');
        } catch (\Exception $e) {
            return $this->error('Lỗi khi nâng cấp: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Tạm dừng / Kích hoạt lại gói
     */
    public function toggleSuspend(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:suspend,activate',
        ]);

        try {
            $subscription = $request->action === 'suspend'
                ? $this->subscriptionService->suspend($id)
                : $this->subscriptionService->activate($id);

            $msg = $request->action === 'suspend' ? 'Tạm dừng gói thành công' : 'Kích hoạt gói thành công';
            return $this->success($subscription, $msg);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->notFound('Không tìm thấy đăng ký');
        } catch (\Exception $e) {
            return $this->error('Lỗi: ' . $e->getMessage(), null, 500);
        }
    }
}