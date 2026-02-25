<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @group Authentication
 *
 * Quản lý xác thực người dùng, phiên đăng nhập và hồ sơ cá nhân.
 * Sử dụng Laravel Sanctum token-based authentication.
 */
class AuthController extends BaseApiController
{
    public function __construct(protected AuthService $authService) {}

    // ================================================================
    // PUBLIC ENDPOINTS (không cần auth)
    // ================================================================

    /**
     * POST /api/v1/auth/login
     * Đăng nhập và nhận Bearer token.
     */
    public function adminLogin(LoginRequest $request): JsonResponse
    {        
        try {
            
            $result = $this->authService->login(
                $request->only('email', 'password'),
                $request->input('device_name', 'api-client'),
                $request->ip()
            );
            return $this->success($result, 'Đăng nhập thành công');

        } catch (ValidationException $e) {
            return $this->error($e->errors()['email'][0] ?? 'Thông tin đăng nhập không hợp lệ.', 401);
        }
    }

    // ================================================================
    // AUTHENTICATED ENDPOINTS (cần Bearer token)
    // ================================================================

    /**
     * POST /api/v1/auth/logout
     * Đăng xuất — xóa token hiện tại.
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());
        return $this->success(null, 'Đăng xuất thành công');
    }

    /**
     * POST /api/v1/auth/logout-all
     * Đăng xuất toàn bộ thiết bị — xóa tất cả token.
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $count = $this->authService->logoutAll($request->user());
        return $this->success(['revoked_tokens' => $count], "Đã đăng xuất {$count} phiên.");
    }

    /**
     * GET /api/v1/auth/me
     * Lấy thông tin tài khoản đang đăng nhập.
     */
    public function me(Request $request): JsonResponse
    {
        return $this->success($this->authService->getProfile($request->user()));
    }

    /**
     * PUT /api/v1/auth/profile
     * Cập nhật thông tin cá nhân (chỉ name).
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = $this->authService->updateProfile($request->user(), $request->only('name'));
        return $this->success($this->authService->getProfile($user), 'Cập nhật thông tin thành công');
    }

    /**
     * POST /api/v1/auth/change-password
     * Đổi mật khẩu — các token khác bị thu hồi sau khi đổi.
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $this->authService->changePassword(
                $request->user(),
                $request->current_password,
                $request->new_password
            );
            return $this->success(null, 'Đổi mật khẩu thành công. Các phiên khác đã bị đăng xuất.');

        } catch (ValidationException $e) {
            return $this->error(
                $e->errors()['current_password'][0] ?? 'Đổi mật khẩu thất bại.',
                422,
                $e->errors()
            );
        }
    }

    /**
     * GET /api/v1/auth/sessions
     * Danh sách các phiên đăng nhập đang hoạt động.
     */
    public function sessions(Request $request): JsonResponse
    {
        return $this->success($this->authService->getActiveSessions($request->user()));
    }

    /**
     * DELETE /api/v1/auth/sessions/{tokenId}
     * Thu hồi một phiên đăng nhập cụ thể.
     */
    public function revokeSession(Request $request, int $tokenId): JsonResponse
    {
        $revoked = $this->authService->revokeSession($request->user(), $tokenId);

        if (!$revoked) {
            return $this->notFound('Không tìm thấy phiên đăng nhập này.');
        }

        return $this->success(null, 'Thu hồi phiên đăng nhập thành công.');
    }

    // ================================================================
    // ADMIN ENDPOINTS (cần role admin/super_admin)
    // ================================================================

    /**
     * GET /api/v1/auth/users
     * [Admin] Danh sách tài khoản người dùng.
     */
    public function listUsers(Request $request): JsonResponse
    {
        $this->authorizeRole($request->user(), ['admin', 'super_admin']);

        $query = User::query()->with('customer');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        return $this->success(
            $query->orderBy('role')->orderBy('name')->paginate($request->integer('per_page', 20))
        );
    }

    /**
     * GET /api/v1/auth/users/{id}
     * [Admin] Chi tiết một tài khoản.
     */
    public function showUser(Request $request, int $id): JsonResponse
    {
        $this->authorizeRole($request->user(), ['admin', 'super_admin']);

        $user = User::with('customer')->findOrFail($id);
        return $this->success($user);
    }

    /**
     * POST /api/v1/auth/users
     * [Admin] Tạo tài khoản mới.
     */
    public function createUser(Request $request): JsonResponse
    {
        $this->authorizeRole($request->user(), ['admin', 'super_admin']);

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users',
            'password'    => 'required|string|min:8|confirmed',
            'role'        => 'required|in:admin,staff,customer',
            'customer_id' => 'nullable|exists:customers,id',
            'is_active'   => 'nullable|boolean',
        ]);

        // Chỉ super_admin mới tạo được admin
        if ($request->role === 'admin' && !$request->user()->isSuperAdmin()) {
            return $this->error('Chỉ Super Admin mới có quyền tạo tài khoản Admin.', 403);
        }

        $user = $this->authService->createUser($request->all());
        return $this->created($user, 'Tạo tài khoản thành công');
    }

    /**
     * PUT /api/v1/auth/users/{id}
     * [Admin] Cập nhật tài khoản.
     */
    public function updateUser(Request $request, int $id): JsonResponse
    {
        $this->authorizeRole($request->user(), ['admin', 'super_admin']);

        $request->validate([
            'name'        => 'sometimes|string|max:255',
            'email'       => "sometimes|email|unique:users,email,{$id}",
            'password'    => 'sometimes|string|min:8|confirmed',
            'role'        => 'sometimes|in:admin,staff,customer',
            'customer_id' => 'nullable|exists:customers,id',
            'is_active'   => 'sometimes|boolean',
        ]);

        try {
            $user = $this->authService->updateUser($id, $request->all(), $request->user());
            return $this->success($user, 'Cập nhật tài khoản thành công');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 403);
        }
    }

    /**
     * DELETE /api/v1/auth/users/{id}
     * [Admin] Xóa tài khoản (soft delete).
     */
    public function deleteUser(Request $request, int $id): JsonResponse
    {
        $this->authorizeRole($request->user(), ['admin', 'super_admin']);

        try {
            $this->authService->deleteUser($id, $request->user());
            return $this->success(null, 'Xóa tài khoản thành công');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 403);
        }
    }

    // ================================================================
    // Private helpers
    // ================================================================

    private function authorizeRole(User $user, array $roles): void
    {
        if (!$user->hasRole($roles)) {
            abort(403, 'Bạn không có quyền thực hiện thao tác này.');
        }
    }
}
