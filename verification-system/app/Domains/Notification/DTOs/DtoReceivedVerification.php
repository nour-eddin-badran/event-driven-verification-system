<?php

namespace App\Domains\Notification\DTOs;

use App\Domains\Notification\Enums\SlugEnum;
use App\Domains\Verification\Enums\SubjectTypeEnum;

class DtoReceivedVerification
{
    public function __construct(private string $id, private string $code, private string $identity, private string $type, private string $occurredOn)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getType(): string
    {
        return match($this->type) {
            SubjectTypeEnum::EMAIL_CONFIRMATION->value => SlugEnum::EMAIL_VERIFICATION->value,
            SubjectTypeEnum::MOBILE_CONFIRMATION->value => SlugEnum::MOBILE_VERIFICATION->value,
        };
    }

    public function getOccurredOn(): string
    {
        return $this->occurredOn;
    }
}