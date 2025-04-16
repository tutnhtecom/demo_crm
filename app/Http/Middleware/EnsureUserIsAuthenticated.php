<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth; // Sử dụng JWTAuth để kiểm tra token
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
class EnsureUserIsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $params = $request->all();
        $token = $request->cookie('jwt_token') ? $request->cookie('jwt_token') : '';
        if(isset($params['token'])){
            $token = $params['token'];
        }
        // Kiểm tra điều kiện bỏ qua middleware nếu truy cập bằng url Mobile
        // if ($request->is('hte-mobile/*')) {
        //     $user_token = JWTAuth::setToken($token)->authenticate();
        //     $user = auth()->user();
        //     return $next($request);
        // }


        try {
            if (!$token) {
                if (session()->has('jwt-token')) {
                    $token = session('jwt-token');
                }else{
                    return response()->view('crm.auth.login');
                }
                // return response()->json(['status' => 'Authorization Token not found 1'], 401);
            }else{
                session(['jwt-token' => $token]);
                session()->save();
            }
            $user = JWTAuth::setToken($token)->authenticate();
            Auth::login($user);

            // dd(Auth::check());
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return  response()->view('crm.auth.login');
                // return response()->json(['status' => 'Token is Invalid'], 401);
            } else if ($e instanceof TokenExpiredException) {
                return  response()->view('crm.auth.login');
                // return response()->json(['status' => 'Token is Expired'], 401);
            } else {
                // return response()->json(['status' => 'Authorization Token not found'], 401);
                return  response()->view('crm.auth.login');
            }
        }
        return $next($request);
    }
}
