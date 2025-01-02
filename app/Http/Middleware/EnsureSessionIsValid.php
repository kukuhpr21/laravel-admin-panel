<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Utils\SessionUtils;
use Symfony\Component\HttpFoundation\Response;

class EnsureSessionIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $unprotectedPath = ['login'];
        $sessionUtils = new SessionUtils();

        if ($sessionUtils->isExist()) {
            if (in_array($request->path(), $unprotectedPath)) {
                return redirect()->route("dashboard");
            }

            $tempRole = $sessionUtils->get('temp_role');

            $tempRoleIsNotEmpty = !empty($tempRole);

            if ($tempRoleIsNotEmpty) {

                $isMultiRole = count(json_decode($tempRole, true)) > 1;

                if ($isMultiRole) {

                    if ($request->path() != 'choose-role') {

                        return redirect()->route('choose-role');
                    }
                }

                return $next($request);
            }

            return $next($request);
        }

        if (in_array($request->path(), $unprotectedPath)) {
            return $next($request);
        }
        return redirect()->route("login");
    }
}
