<?php

namespace App\DTOs;


class DtoTemplate
{
    public function __construct(private string $slug, private string $code) { }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}