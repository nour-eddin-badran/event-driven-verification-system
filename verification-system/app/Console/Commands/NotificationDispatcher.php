<?php

namespace App\Console\Commands;

use App\Domains\Notification\Models\Notification;
use App\Domains\Notification\Repositories\NotificationRepository;
use App\Notifications\EmailNotification;
use App\Notifications\MobileNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class NotificationDispatcher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification-dispatcher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is responsible for dispatching the notifications';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query = Notification::where('dispatched', false);

        $totalCount = $query->count();
        $offset = 0;
        $limit = 50;
        $notificationsIds = [];

        try {
            for ($offset = 0; $offset < $totalCount; $offset += $limit) {
                $notifications = $query->offset($offset)->limit($limit)->get();

                // notify the target clients
                foreach ($notifications as $notification) {
                    if ($notification->channel == 'email-verification') {
                        $notification->email = $notification->recipient;
                        $notification->notify(new EmailNotification($notification->body));
                    } else if ($notification->channel == 'mobile-verification') {
                        $notification->notify(new MobileNotification($notification->body));
                    }

                    $notificationsIds [] = $notification->id;
                }
            }

        } catch (\Throwable $e)
        {
            Log::error($e->getMessage());
        }

        // delete the handled reminders
        if (count($notificationsIds) > 0) {
            $notificationRepo = app(NotificationRepository::class);
            $notificationRepo->markAsDispatched($notificationsIds);
        }

    }
}
