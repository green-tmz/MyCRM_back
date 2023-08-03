<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthorize
{
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('superAdmin')->user();
        if (!empty($user)) {
            return $next($request);
        }

        return redirect()->route('api.docs');
    }
}
