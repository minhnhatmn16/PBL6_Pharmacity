<?php

namespace App\Enums;

use Illuminate\Support\Facades\URL;

class UserEnum extends BaseEnum
{
    public const URL_CLIENT2 = 'https://minhdeptrai.netlify.app/';
    public const VERIFY_MAIL_USER = 'http://localhost:3000/auth/verify-email/user?token=';
    public const FORGOT_PASSWORD_USER = 'http://localhost:3000/auth/forgot-password/user?token=';
    public const URL_CLIENT = 'http://localhost:3000';
    public const URL_SERVER = 'https://lucifernsz.com/PBL6-BE/public/api';

}
