<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\Profile\ProfileDto;
use App\Utils\CryptUtils;
use App\Utils\SessionUtils;
use App\Utils\ResponseUtils;
use App\Utils\ToastUtils;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\ChangeProfileRequest;
use App\Http\Requests\changePasswordRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{

    use ResponseUtils;
    use ToastUtils;

    private UserService $userService;
    private ProfileService $profileService;
    private SessionUtils $sessionUtils;

    public function __construct(UserService $userService, ProfileService $profileService) {
        $this->userService = $userService;
        $this->profileService = $profileService;
        $this->sessionUtils = new SessionUtils();
    }
    public function profile()
    {
        $response     = $this->userService->findOne($this->sessionUtils->get('id'));
        $data         = json_decode($response['data']);
        $data->id     = CryptUtils::enc($data->id);
        ToastUtils::successToast('Failed change password, do not use default password');
        return view('pages.app.profile.index', compact('data'));
    }

    public function changeProfile(ChangeProfileRequest $request, $id)
    {
        $idDecrypt = CryptUtils::dec($id);
        $user  = $this->userService->findOne($idDecrypt);

        if (!ResponseUtils::isSuccess($user)) {
            return abort(404);
        }

        $response = $this->profileService->changeProfile(ProfileDto::fromRequestChangeProfile($request, $idDecrypt));
        ResponseUtils::showToast($response);
        return redirect()->route('profile');
    }

    public function changePassword(changePasswordRequest $request, $id)
    {
        $idDecrypt = CryptUtils::dec($id);
        $user  = $this->userService->findOne($idDecrypt);

        if (!ResponseUtils::isSuccess($user)) {
            return abort(404);
        }

        $response = $this->profileService->changePassword(ProfileDto::fromRequestChangePassword($request, $idDecrypt));
        ResponseUtils::showToast($response);
        return redirect()->route('profile');
    }
}
