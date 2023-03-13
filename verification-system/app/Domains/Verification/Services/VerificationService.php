<?php

namespace App\Domains\Verification\Services;

use App\Domains\Verification\DTOs\DtoUserInfo;
use App\Domains\Verification\DTOs\DtoVerification;
use App\Domains\Verification\Models\Verification;
use App\Domains\Verification\Repositories\VerificationRepository;
use Illuminate\Http\Response;

class VerificationService
{
    public function __construct(private VerificationRepository $verificationRepository)
    {
    }

    public function storeVerification(DtoVerification $verification): Verification
    {
        $userInfo = new DtoUserInfo();
        $latestConfirmedVerification = $this->verificationRepository->getConfirmedVerificationInfo($verification, $userInfo);

        if ($latestConfirmedVerification) {
            throw new \Exception('Already confirmed', Response::HTTP_CONFLICT);
        }

        $latestValidVerification = $this->verificationRepository->getLatestValidVerificationInfo($verification, $userInfo);

        if ($latestValidVerification) {
            throw new \Exception('Duplicated verification.',Response::HTTP_CONFLICT);
        }

        return $this->verificationRepository->create($verification, $userInfo);
    }

    public function confirmVerification(Verification $verification, string $code): void
    {
        $userInfo = new DtoUserInfo();

        if (!$this->isVerificationMatchedUserInfo($verification, $userInfo)) {
            throw new \Exception('No permission to confirm verification.', Response::HTTP_FORBIDDEN);
        }

        if ($verification->confirmed) {
            throw new \Exception('Already confirmed', Response::HTTP_CONFLICT);
        }

        if ($verification->is_expired) {
            throw new \Exception('Verification expired.', Response::HTTP_GONE);
        }

        if ($verification->attempts_count == 5) {
            $this->verificationRepository->makeItExpired($verification);
            throw new \Exception('Verification expired.', Response::HTTP_GONE);
        }

        if ($verification->code != $code) {
            $this->verificationRepository->increaseAttemptsCountByOne($verification);
            throw new \Exception('Validation failed: invalid code supplied.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->verificationRepository->makeItConfirmed($verification);
    }

    private function isVerificationMatchedUserInfo(Verification $verification, DtoUserInfo $userInfo): bool
    {
        return isset($verification->user_info['client_ip']) && isset($verification->user_info['user_agent']) && $verification->user_info['client_ip'] == $userInfo->getClientIP() && $verification->user_info['user_agent'] == $userInfo->getUserAgent();
    }
}
