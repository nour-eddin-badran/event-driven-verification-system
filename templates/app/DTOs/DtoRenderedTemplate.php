<?php

namespace App\DTOs;


class DtoRenderedTemplate
{
    public function __construct(private string $template, private array $headers) { }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}