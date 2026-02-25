<?php

namespace App\Http\Controllers\Api;

use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Quản lý Gói cước
 */
class PackageController extends BaseApiController
{
    /**
     * Danh sách gói cước
     */
    public function index(Request $request): JsonResponse
    {
        $query = Package::query();

        if ($request->boolean('active_only', true)) {
            $query->active();
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $packages = $query->ordered()->get();

        return $this->success($packages, 'Lấy danh sách gói cước thành công');
    }

    /**
     * Chi tiết gói cước
     */
    public function show(int $id): JsonResponse
    {
        $package = Package::with('activeSubscriptions')->find($id);

        if (!$package) {
            return $this->notFound('Không tìm thấy gói cước');
        }

        return $this->success($package, 'Lấy thông tin gói cước thành công');
    }

    /**
     * Tạo mới gói cước
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code'                          => 'required|string|max:20|unique:packages,code',
            'name'                          => 'required|string|max:100',
            'description'                   => 'nullable|string',
            'type'                          => 'required|in:basic,standard,premium,enterprise',
            'price_monthly'                 => 'required|numeric|min:0',
            'price_yearly'                  => 'nullable|numeric|min:0',
            'sip_account_limit'             => 'nullable|integer|min:1',
            'concurrent_call_limit'         => 'nullable|integer|min:1',
            'free_minutes_domestic'         => 'nullable|integer|min:0',
            'free_minutes_international'    => 'nullable|integer|min:0',
            'rate_per_minute_domestic'      => 'nullable|numeric|min:0',
            'rate_per_minute_international' => 'nullable|numeric|min:0',
            'storage_gb'                    => 'nullable|integer|min:0',
            'features'                      => 'nullable|array',
            'sort_order'                    => 'nullable|integer',
        ]);

        $package = Package::create($validated);

        return $this->created($package, 'Tạo gói cước thành công');
    }

    /**
     * Cập nhật gói cước
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $package = Package::findOrFail($id);

        $validated = $request->validate([
            'name'                          => 'nullable|string|max:100',
            'description'                   => 'nullable|string',
            'price_monthly'                 => 'nullable|numeric|min:0',
            'price_yearly'                  => 'nullable|numeric|min:0',
            'sip_account_limit'             => 'nullable|integer|min:1',
            'concurrent_call_limit'         => 'nullable|integer|min:1',
            'free_minutes_domestic'         => 'nullable|integer|min:0',
            'features'                      => 'nullable|array',
            'status'                        => 'nullable|in:active,inactive,discontinued',
            'sort_order'                    => 'nullable|integer',
        ]);

        $package->update($validated);

        return $this->success($package->fresh(), 'Cập nhật gói cước thành công');
    }
}