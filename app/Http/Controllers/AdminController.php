<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests\RequestLogin;
use App\Http\Requests\RequestForgotPassword;
use App\Http\Requests\RequestResetPassword;
use App\Http\Requests\RequestUpdateProfileAdmin;
use App\Http\Requests\RequestChangePassword;
use App\Http\Requests\RequestAddAdmin;
use App\Http\Requests\RequestResendVerifyEmail;

use App\Services\AdminService;


class AdminController extends Controller
{
    protected AdminService $adminService;
    public function __construct(AdminService $adminService) {
        $this->adminService = $adminService;
    }
    public function login(RequestLogin $request)
    {
        return $this->adminService->login($request);
    }
    public function forgotPassword(RequestForgotPassword $request)
    {
        return $this->adminService->forgotPassword($request);
    }
    public function resetPassword(RequestResetPassword $request)
    {
        return $this->adminService->resetPassword($request);
    }
    public function logout(Request $request){
        return $this->adminService->logout($request);
    }
    public function profile(Request $request){
        return $this->adminService->profile($request);
    }
    public function updateProfile(RequestUpdateProfileAdmin $request){
        return $this->adminService->updateProfile($request);
    }
    public function changePassword(RequestChangePassword $request){
        return $this->adminService->changePassword($request);
    }
    public function manageUsers(Request $request){
        return $this->adminService->manageUsers($request);
    }
    public function manageAdmins(Request $request){
        return $this->adminService->manageAdmins($request);
    }
    public function changeRole(Request $request){
        return $this->adminService->changeRole($request);
    }
    public function changeBlock(Request $request){
        return $this->adminService->changeBlock($request);
    }
    public function deleteUser(Request $request){
        return $this->adminService->deleteUser($request);
    }
    public function addAdmin(RequestAddAdmin $request){
        return $this->adminService->addAdmin($request);
    } 
    public function verifyEmail(Request $request){
        return $this->adminService->verifyEmail($request);
    }
    public function deleteAdmin(Request $request){
        return $this->adminService->deleteAdmin($request);
    }
    public function resendVerifyEmail(RequestResendVerifyEmail $request){
        return $this->adminService->resendVerifyEmail($request);
    }
}

