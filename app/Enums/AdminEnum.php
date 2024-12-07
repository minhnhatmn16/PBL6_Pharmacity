<?php

namespace App\Enums;

class AdminEnum extends BaseEnum
{
    public const VERIFY_MAIL_ADMIN = 'http://localhost:3000/auth/verify-email/admin?token=';
    public const FORGOT_PASSWORD_ADMIN = 'http://localhost:3000/auth/forgot-password/admin?token=';
    public const URL_ADMIN = 'https://minhdeptrai.netlify.app';

}
