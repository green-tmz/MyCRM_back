<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\DB;

class LastOnlineAt
{
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            return $next($request);
        }

        /** @var User $authUser */
        // $authUser = auth()->user();
        // if ($authUser->last_online_at->diffInMinutes(now()) > 1) {
        //     DB::table('users')
        //         ->where('id', $authUser->getAuthIdentifier())
        //         ->update(['last_online_at' => now()]);
        // }

        return $next($request);
    }
}
