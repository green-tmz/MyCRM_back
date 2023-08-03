<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Modules\Admin\Models\SuperUser;
use App\Modules\Settings\Models\Role;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();
        if ($user) {
            /** @var PersonalAccessToken $token */
            $token = $user->tokens()->where('name', 'accessToken')->first();
            if (!empty($token)) {
                $user->withAccessToken($token);
            }
        }

        unset($user, $token, $abilities);

        return $next($request);
    }
}
