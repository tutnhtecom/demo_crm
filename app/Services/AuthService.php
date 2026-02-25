<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Đăng nhập, trả về token Sanctum.
     */
    public function login(array $credentials, string $deviceName = 'api', string $ip = null): array
    {
        $user = User::where('email', $credentials['email'])->first();        
    
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email hoặc mật khẩu không chính xác.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Tài khoản đã bị vô hiệu hóa. Vui lòng liên hệ quản trị viên.'],
            ]);
        }

        // Xóa token cũ cùng device (tránh tích lũy token)
        $user->tokens()->where('name', $deviceName)->delete();

        $token = $user->createToken($deviceName, $user->tokenAbilities());

        // Cập nhật thông tin đăng nhập cuối
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
        ]);

        return [
            'user'         => $this->formatUserProfile($user),
            'access_token' => $token->plainTextToken,
            'token_type'   => 'Bearer',
            'abilities'    => $user->tokenAbilities(),
            'expires_at'   => null, // Sanctum token không hết hạn mặc định; cấu hình trong sanctum.php
        ];
    }

    /**
     * Đăng xuất: xóa token hiện tại.
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    /**
     * Đăng xuất toàn bộ thiết bị.
     */
    public function logoutAll(User $user): int
    {
        return $user->tokens()->delete();
    }

    /**
     * Lấy thông tin profile người dùng hiện tại.
     */
    public function getProfile(User $user): array
    {
        $user->load('customer');
        return $this->formatUserProfile($user);
    }

    /**
     * Đổi mật khẩu.
     */
    public function changePassword(User $user, string $currentPassword, string $newPassword): void
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Mật khẩu hiện tại không chính xác.'],
            ]);
        }

        $user->update(['password' => Hash::make($newPassword)]);

        // Đăng xuất tất cả token khác (bảo mật)
        $user->tokens()->where('id', '!=', $user->currentAccessToken()->id)->delete();
    }

    /**
     * Cập nhật thông tin profile.
     */
    public function updateProfile(User $user, array $data): User
    {
        $allowed = ['name'];
        $user->update(array_intersect_key($data, array_flip($allowed)));
        return $user->fresh();
    }

    /**
     * Lấy danh sách token đang hoạt động.
     */
    public function getActiveSessions(User $user): array
    {
        return $user->tokens()
            ->orderByDesc('last_used_at')
            ->get(['id', 'name', 'last_used_at', 'created_at', 'expires_at'])
            ->toArray();
    }

    /**
     * Thu hồi một token cụ thể.
     */
    public function revokeSession(User $user, int $tokenId): bool
    {
        return (bool) $user->tokens()->where('id', $tokenId)->delete();
    }

    // ----------------------------------------------------------------
    // Admin methods
    // ----------------------------------------------------------------

    /**
     * Admin tạo user mới.
     */
    public function createUser(array $data): User
    {
        return User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'role'        => $data['role'] ?? 'staff',
            'customer_id' => $data['customer_id'] ?? null,
            'is_active'   => $data['is_active'] ?? true,
        ]);
    }

    /**
     * Admin cập nhật user.
     */
    public function updateUser(int $userId, array $data, User $actingUser): User
    {
        $user = User::findOrFail($userId);

        // Không cho phép hạ cấp super_admin bởi admin thường
        if ($user->isSuperAdmin() && !$actingUser->isSuperAdmin()) {
            throw new \Exception('Không có quyền chỉnh sửa tài khoản Super Admin.');
        }

        $allowed = ['name', 'email', 'role', 'customer_id', 'is_active'];
        $updateData = array_intersect_key($data, array_flip($allowed));

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
            // Thu hồi toàn bộ token khi admin reset mật khẩu
            $user->tokens()->delete();
        }

        $user->update($updateData);
        return $user->fresh();
    }

    /**
     * Admin xóa user.
     */
    public function deleteUser(int $userId, User $actingUser): bool
    {
        $user = User::findOrFail($userId);

        if ($user->id === $actingUser->id) {
            throw new \Exception('Không thể tự xóa tài khoản của chính mình.');
        }
        if ($user->isSuperAdmin()) {
            throw new \Exception('Không thể xóa tài khoản Super Admin.');
        }

        $user->tokens()->delete();
        return $user->delete();
    }

    // ----------------------------------------------------------------
    // Private helpers
    // ----------------------------------------------------------------

    private function formatUserProfile(User $user): array
    {
        return [
            'id'            => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'role'          => $user->role,
            'is_active'     => $user->is_active,
            'customer'      => $user->customer ? [
                'id'   => $user->customer->id,
                'code' => $user->customer->code,
                'name' => $user->customer->name,
            ] : null,
            'last_login_at' => $user->last_login_at?->toDateTimeString(),
            'last_login_ip' => $user->last_login_ip,
            'created_at'    => $user->created_at?->toDateTimeString(),
        ];
    }
}
