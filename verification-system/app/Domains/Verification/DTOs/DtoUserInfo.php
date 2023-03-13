<?php

namespace App\Domains\Verification\DTOs;

class DtoUserInfo
{
    public function getClientIP(): string
    {
        return \request()->getClientIp();
    }

    public function getUserAgent(): string
    {
        return \request()->userAgent();
    }
}