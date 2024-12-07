<?php

namespace App\Http\Middleware;

use App\Traits\APIResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthenticate
{
    use APIResponse;
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            // dd(Auth::guard($guard)->user());
            if (Auth::guard($guard)->check()) {
                return $next($request);
            }
        }
        
        // Sử dụng response() để tạo một đối tượng Response thay vì JsonResponse
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}
