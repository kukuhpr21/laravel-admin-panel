<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Session\SessionService;
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

            $tempRoleIsNotEmpty = !empty($sessionUtils->get('temp_role'));

            $isMultiRole = count(json_decode($sessionUtils->get('temp_role'))) > 1;

            if ($tempRoleIsNotEmpty && $isMultiRole) {

                if ($request->path() != 'choose-role') {

                    return redirect()->route('choose-role');
                }
            }

            return $next($request);
        }

        if (in_array($request->path(), $unprotectedPath)) {
            return $next($request);
        }
        return redirect()->route("login");
    }
}
