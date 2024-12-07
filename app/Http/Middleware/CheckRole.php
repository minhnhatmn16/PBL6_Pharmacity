<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $admin = auth('admin_api')->user();
        if (! $admin) {
            return response()->json(['status' => 'Unauthorized'],401); 
        }
        // if ($admin->admin_is_admin = 0) {
        //     return response()->json(['message' => 'Bạn không có quyền truy cập!'], 403);
        // }

        if (in_array($admin->admin_is_admin,$roles)){
            return $next($request);
        }
        
        return response()->json(['status' => 'Bạn không có quyền truy cập!'],403); 
    }
}
