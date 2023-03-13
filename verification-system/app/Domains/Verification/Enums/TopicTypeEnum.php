<?php

namespace App\Domains\Verification\Enums;

enum TopicTypeEnum: string
{
    case VERIFICATION_CREATED = 'VerificationCreated';
    case VERIFICATION_CONFIRMED = 'VerificationConfirmed';
    case VERIFICATION_CONFIRMATION_FAILED = 'VerificationConfirmationFailed';
}