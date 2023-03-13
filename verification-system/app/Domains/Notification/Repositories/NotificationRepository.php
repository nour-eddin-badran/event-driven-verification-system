<?php

namespace App\Domains\Notification\Repositories;

use App\Domains\Notification\DTOs\DtoNotification;
use App\Domains\Notification\Models\Notification;

class NotificationRepository
{
    public function __construct(private Notification $notification)
    {
    }

    public function create(DtoNotification $dtoNotification)
    {
        $this->notification->create([
           'recipient' => $dtoNotification->getRecipient(),
           'channel' => $dtoNotification->getChannel(),
           'body' => $dtoNotification->getBody(),
        ]);
    }

    public function markAsDispatched(array $ids): void
    {
        $this->notification->whereIn('id', $ids)->update([
            'dispatched' => true
        ]);
    }
}