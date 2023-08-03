<?php

namespace App\Http\Middleware;

use App\Modules\Admin\Models\SuperUser;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class SuperUserTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     * @throws HttpResponseException
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() instanceof SuperUser) {
            return $next($request);
        }

        throw new HttpResponseException(response()->json([
            'error' => [
                'error_code' => 1,
                'error_msg' => 'У Вас нет доступа',
            ]
        ], 422));
    }
}
