<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\SessionUtils;
use App\Utils\ResponseUtils;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\DataTransferObjects\Auth\LoginPostDto;

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
    }

    public function chooseRole()
    {
        $sessionUtils = new SessionUtils();
        $maps         = ['id' => 'value', 'name' => 'text'];
        $tempRole     = $this->parsingTempRole(json_decode($sessionUtils->get('temp_role')));
        $roles        = ArrayUtils::transform($tempRole, $maps);
        return view('pages.guest.choose-role', compact('roles'));
    }

    public function doChooseRole()
    {

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
}
