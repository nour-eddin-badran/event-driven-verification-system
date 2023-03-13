<?php

namespace App\Domains\Notification\Enums;

enum SlugEnum: string
{
    case MOBILE_VERIFICATION = 'mobile-verification';
    case EMAIL_VERIFICATION = 'email-verification';
}