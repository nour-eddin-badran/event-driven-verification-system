<?php

namespace App\Domains\Notification\Enums;

enum TopicTypeEnum: string
{
    case NOTIFICATION_CREATED = 'NotificationCreated';
    case NOTIFICATION_DISPATCHED = 'NotificationDispatched';
}