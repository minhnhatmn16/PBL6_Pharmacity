<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestChangePassword;
use App\Http\Requests\RequestForgotPassword;
use App\Http\Requests\RequestLogin;
use App\Http\Requests\RequestResetPassword;
use App\Http\Requests\RequestUpdateProfileUser;
use App\Http\Requests\RequestUserRegister;
use App\Http\Requests\RequestResendVerifyEmail;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function register(RequestUserRegister $request)
    {
        return $this->userService->register($request);
    }
    public function verifyEmail(Request $request)
    {
        return $this->userService->verifyEmail($request);
    }

    public function login(RequestLogin $request)
    {
        return $this->userService->login($request);
    }
    public function forgotPassword(RequestForgotPassword $request)
    {
        return $this->userService->forgotPassword($request);
    }
    public function resetPassword(RequestResetPassword $request)
    {
        return $this->userService->resetPassword($request);
    }
    public function logout(Request $request)
    {
        return $this->userService->logout($request);
    }
    public function profile(Request $request){
        return $this->userService->profile($request);
    }
    public function updateProfile(RequestUpdateProfileUser $request){
        return $this->userService->updateProfile($request);
    }
    public function changePassword(RequestChangePassword $request){
        return $this->userService->changePassword($request);
    }
    public function resendVerifyEmail(RequestResendVerifyEmail $request){
        return $this->userService->resendVerifyEmail($request);
    }
}
