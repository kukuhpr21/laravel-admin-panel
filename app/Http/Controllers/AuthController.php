<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\Auth\ChangePasswordDto;
use App\Utils\ArrayUtils;
use App\Utils\SessionUtils;
use App\Utils\ResponseUtils;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ChooseRolePostRequest;
use App\DataTransferObjects\Auth\LoginPostDto;
use App\Http\Requests\AuthChangePasswordRequest;
use App\Utils\CacheUtils;

class AuthController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login()
    {
        return view('pages.guest.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $response = $this->authService->login(LoginPostDto::fromRequest($request));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->withInput();
    }

    public function changePassword()
    {
        return view('pages.guest.change-password');
    }

    public function doChangePassword(AuthChangePasswordRequest $request)
    {
        $response = $this->authService->changePassword(ChangePasswordDto::fromRequest($request));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('login');
        }
        return redirect()->back()->withInput();
    }

    public function chooseRole()
    {
        $sessionUtils = new SessionUtils();
        $maps         = ['id' => 'value', 'name' => 'text'];
        $tempRole     = $sessionUtils->get('temp_role');
        $tempRole     = json_decode($tempRole);
        $tempRole     = $this->parsingTempRole($tempRole);
        $roles        = ArrayUtils::transform($tempRole, $maps);
        return view('pages.guest.choose-role', compact('roles'));
    }

    public function doChooseRole(ChooseRolePostRequest $request)
    {
        if ($request->validated()) {
            $sessionUtils = new SessionUtils();
            $tempRole = $sessionUtils->get('temp_role');

            $tempRoleDecode = json_decode($tempRole, true);

            foreach ($tempRoleDecode as $item) {
                if ($item['id'] == $request['role']) {
                    $role = json_encode($item);
                    $userID = $sessionUtils->get('id');
                    $sessionUtils->save('role', $role);
                    $sessionUtils->delete('temp_role');
                    CacheUtils::put("role", $userID, $role);
                    break;
                }
            }
            return redirect()->route('dashboard');
        }
    }

    private function parsingTempRole($tempRole)
    {
        $result = [];

        foreach ($tempRole as $key => $value) {
            array_push($result, [
                'id' => $value->id,
                'name' => $value->name,
            ]);
        }

        return $result;
    }

    public function doLogout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
