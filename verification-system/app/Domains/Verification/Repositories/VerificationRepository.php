<?php

namespace App\Domains\Verification\Repositories;

use App\Domains\Verification\DTOs\DtoUserInfo;
use App\Domains\Verification\DTOs\DtoVerification;
use App\Domains\Verification\Models\Verification;
use Illuminate\Support\Carbon;

class VerificationRepository
{
    public function __construct(private Verification $verification)
    {
    }

    public function create(DtoVerification $verification, DtoUserInfo $userInfo): Verification
    {
        return $this->verification->create([
            'identity' => $verification->getIdentity(),
            'type' => $verification->getType(),
            'confirmed' => false,
            'code' => $verification->getCode(),
            'user_info' => [
                'client_ip' => $userInfo->getClientIP(),
                'user_agent' => $userInfo->getUserAgent()
            ]
        ]);
    }

    public function getLatestValidVerificationInfo(DtoVerification $verification, DtoUserInfo $userInfo): ?Verification
    {
        return Verification::where([
            'identity' => $verification->getIdentity(),
            'type' => $verification->getType(),
        ])->where(['confirmed' => false, 'is_expired' => false])
            ->whereJsonContains('user_info', ["client_ip" => $userInfo->getClientIP(), "user_agent" => $userInfo->getUserAgent()])
            ->orderByDesc('created_at')->first();
    }

    public function getConfirmedVerificationInfo(DtoVerification $verification, DtoUserInfo $userInfo): ?Verification
    {
        return Verification::where([
            'identity' => $verification->getIdentity(),
            'type' => $verification->getType(),
        ])->where(['confirmed' => true, 'is_expired' => false])
            ->whereJsonContains('user_info', ["client_ip" => $userInfo->getClientIP(), "user_agent" => $userInfo->getUserAgent()])
            ->orderByDesc('created_at')->first();
    }

    public function increaseAttemptsCountByOne(Verification $verification): void
    {
        $verification->attempts_count += 1;
        $verification->save();
    }

    public function makeItExpired(Verification $verification): void
    {
        $verification->is_expired = true;
        $verification->save();
    }

    public function makeItConfirmed(Verification $verification): void
    {
        $verification->confirmed = true;
        $verification->confirmed_at = now();
        $verification->save();
    }
}
