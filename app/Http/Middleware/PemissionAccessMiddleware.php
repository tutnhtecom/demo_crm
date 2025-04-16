<?php

namespace App\Http\Middleware;

use App\Models\Leads;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemissionAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // || Auth::user()->id != User::IS_ROOT
    public function handle(Request $request, Closure $next): Response
    {  
        if(!Auth::user())  {
            return redirect()->route('crm.login');
        }
        if (Auth::user()->types == User::TYPE_EMPLOYEES || Auth::user()->id == User::IS_ROOT) {
            return $next($request);           
        }   
        return response()->view('errors.403', ['msg' => 'Bạn không có quyền vào hệ thống'], 403);
    }
}
