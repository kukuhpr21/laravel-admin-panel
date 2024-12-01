<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\Auth\LoginPostDto;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ResponseUtils;

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
        return view('pages.guest.choose-role');
    }

    public function doChooseRole()
    {

    }
}
