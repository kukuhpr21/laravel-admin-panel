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
        return view('pages.guest.choose-role');
    }

    public function doChooseRole()
    {

    }
}
