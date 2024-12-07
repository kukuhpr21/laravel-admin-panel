<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\SessionUtils;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiSessionIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionUtils = new SessionUtils();

        if ($sessionUtils->isExist()) {
            return $next($request);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized',
            'data' => [],
            'errors' => []
        ], 401);
    }
}
