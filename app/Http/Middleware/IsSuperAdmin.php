<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // if (auth()->user()->tokenCan('role:' . $role)) {
        //     return $next($request);
        // }
        // return response()->json('Not Authorized', 401);
        if (!empty(auth()->user()->is_super_admin)) {
            return $next($request);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Route not allowed for this user',
            'data' => []
        ]);
    }
}
