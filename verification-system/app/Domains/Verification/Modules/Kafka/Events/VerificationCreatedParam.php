<?php

namespace App\Domains\Verification\Modules\Kafka\Events;

use App\Domains\Verification\Enums\TopicTypeEnum;
use App\Domains\Verification\Models\Verification;
use App\Modules\Kafka\Contracts\HasBody;
use App\Modules\Kafka\DTOs\DtoKafkaParam;
use App\Modules\Kafka\KafkaParam;

class VerificationCreatedParam extends KafkaParam implements HasBody
{
    public function __construct(private Verification $verification)
    {
    }

    public function getTopicName(): string
    {
        return TopicTypeEnum::VERIFICATION_CREATED->value;
    }

    public function getBody(): DtoKafkaParam
    {
        return new DtoKafkaParam('properties', [
            'id' => $this->verification->uuid,
            'code' => $this->verification->code,
            'subject' => [
                'identity' => $this->verification->identity,
                'type' => $this->verification->type,
            ],
            'occurredOn' => $this->verification->created_at,
        ]);
    }
}