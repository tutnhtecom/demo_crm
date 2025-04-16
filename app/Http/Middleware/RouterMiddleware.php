<?php

namespace App\Http\Middleware;

use App\Models\Permissions;
use App\Models\RolePermissions;
use App\Models\User;
use App\Models\UserRolePermissions;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RouterMiddleware
{
   
    public function handle(Request $request, Closure $next): Response
    {         
        if(!Auth::user())  {
            return redirect()->route('crm.login');
        }
        if (Auth::user()->id == User::IS_ROOT){
            return $next($request);
        }
        if (Auth::user()->types == User::TYPE_EMPLOYEES) {            
            $routeName = $request->route()->getName();
            $permissions_id = Permissions::where('router_name', $routeName)->first()->id;
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
