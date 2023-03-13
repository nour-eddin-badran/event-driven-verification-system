<?php

namespace App\Domains\Notification\Observers;

use App\Domains\Notification\Models\Notification;
use App\Domains\Notification\Modules\Kafka\Events\NotificationCreatedParam;
use App\Domains\Notification\Modules\Kafka\Events\NotificationDispatchedParam;
use App\Jobs\DispatchToKafka;

class NotificationObserver
{
    public function created(Notification $notification)
    {
        DispatchToKafka::dispatch(new NotificationCreatedParam());
    }

    public function updated(Notification $notification)
    {
        if ($notification->isDirty('dispatched')) {
            DispatchToKafka::dispatch(new NotificationDispatchedParam());
        }
    }
}
