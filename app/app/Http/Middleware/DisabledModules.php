<?php

namespace App\Http\Middleware;

use App\Helpers\Helpers;
use App\Modules\Settings\Models\SettingsGeneral;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class DisabledModules
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()->getName();
        if (empty($routeName)) {
            return $next($request);
        }

        $moduleName = explode('.', $routeName)[0];
        if (!str_contains($moduleName, '-module')) {
            return $next($request);
        }

        $disabled = match ($moduleName) {
            'assets-module' => SettingsGeneral::query()
                ->where('code', 'assets')
                ->where('value', '0')
                ->exists(),
            'recruitment-module' => Helpers::isEnvironment(['staging', 'production']) &&
                !env('LICENSE_MODULE_RECRUITMENT_ENABLED', false),
            'surveys-module' => Helpers::isEnvironment(['staging', 'production']) &&
                !env('LICENSE_MODULE_SURVEYS_ENABLED', false),
            'processes-module' => Helpers::isEnvironment(['staging', 'production']) &&
                !env('LICENSE_MODULE_PROCESSES_ENABLED', false),
            'education-module' => Helpers::isEnvironment(['staging', 'production']) &&
                !env('LICENSE_MODULE_EDUCATION_ENABLED', false),
            default => false,
        };

        if ($disabled) {
            throw new HttpResponseException(
                response()->json([
                    'error' => [
                        'error_code' => 4,
                        'error_msg' => __('auth.access_denied'),
                    ]
                ], 403)
            );
        }

        return $next($request);
    }
}
