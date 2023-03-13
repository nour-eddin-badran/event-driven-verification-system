<?php

namespace App\Domains\Notification\DTOs;

class DtoNotification
{
    public function __construct(private string $recipient, private string $channel, private string $body)
    {
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}