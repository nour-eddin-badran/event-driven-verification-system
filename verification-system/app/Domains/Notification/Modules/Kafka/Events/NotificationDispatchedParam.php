<?php

namespace App\Domains\Notification\Modules\Kafka\Events;

use App\Domains\Notification\Enums\TopicTypeEnum;
use App\Modules\Kafka\KafkaParam;

class NotificationDispatchedParam extends KafkaParam
{
    public function getTopicName(): string
    {
        return TopicTypeEnum::NOTIFICATION_DISPATCHED->value;
    }
}