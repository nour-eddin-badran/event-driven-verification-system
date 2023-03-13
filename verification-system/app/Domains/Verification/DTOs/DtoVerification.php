<?php

namespace App\Domains\Verification\DTOs;


class DtoVerification
{
    public function __construct(private string $identity, private string $type) { }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCode(): int
    {
        return rand(1111, 99999999);
    }
}