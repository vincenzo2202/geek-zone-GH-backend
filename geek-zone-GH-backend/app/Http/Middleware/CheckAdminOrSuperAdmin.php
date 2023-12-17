<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; 

class CheckAdminOrSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && ($user->hasRole('admin') || $user->hasRole('super-admin'))) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
