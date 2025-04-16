<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth; // Sử dụng JWTAuth để kiểm tra token
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiUserIsAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->bearerToken();

            JWTAuth::parseToken($token)->authenticate();
            if (!Auth::check()) {
                return response()->json([
                    "code" => 400,
                    "message" => "Vui lòng đăng nhập hệ thống"
                ]);
            }
            return $next($request);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
        if (!Auth::check()) {
            return response()->json([
                "code" => 400,
                "message" => "Vui lòng đăng nhập hệ thống"
            ]);
        }
        return $next($request);

    }
}
