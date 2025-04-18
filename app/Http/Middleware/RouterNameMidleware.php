<?php

namespace App\Http\Middleware;

use App\Models\Permissions;
use App\Models\RolePermissions;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RouterNameMidleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if(!Auth::user())  {
            return redirect()->route('crm.login');
        }
        if (Auth::user()->id == User::IS_ROOT || Auth::user()->employees->roles_id == 1){
            return $next($request);
        }
        if (Auth::user()->types == User::TYPE_EMPLOYEES) {            
            $routeName = $request->route()->getName();
            $permissions = Permissions::where('router_web_name', $routeName)->first();
            if(!isset($permissions->id)) {
                return response()->view('errors.404', ['msg' => 'Bạn không có quyền vào trang này'], 404);
            } else {
                $permissions_id = $permissions->id;
            }
            $roles_id = Auth::user()->employees->roles_id;
            $r_permissions = RolePermissions::where('permissions_id', $permissions_id)
                             ->where('roles_id', $roles_id)
                             ->count();
            if($r_permissions > 0) {
                return $next($request);
            }
        }           
        return response()->view('errors.403', ['msg' => 'Bạn không có quyền vào hệ thống'], 403);        
    }
}
