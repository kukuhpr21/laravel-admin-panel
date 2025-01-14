<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Utils\PermissionCheckUtils;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermissionIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        if ($permission) {
            $path  = $request->path();
            $value = $path.'.'.$permission;

            if (PermissionCheckUtils::execute($value)) {
                return $next($request);
            }
        }
        abort(403);
    }
}
