<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\CacheUtils;
use App\Utils\SessionUtils;
use Illuminate\Http\Request;
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
                $tempRole = json_decode($tempRole, true);
                $isMultiRole = count($tempRole) > 1;

                if ($isMultiRole) {

                    if ($request->path() != 'choose-role') {
                        return redirect()->route('choose-role');
                    }
                } else {
                    $role = json_encode($tempRole[0]);
                    $sessionUtils->save('role', $role);
                    $sessionUtils->delete('temp_role');

                    $userID = $sessionUtils->get('id');
                    CacheUtils::put("role", $userID, $role);

                    return $next($request);
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
