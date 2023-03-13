<?php

namespace App\Domains\Verification\Enums;

enum SubjectTypeEnum: string
{
    case MOBILE_CONFIRMATION = 'mobile_confirmation';
    case EMAIL_CONFIRMATION = 'email_confirmation';
}