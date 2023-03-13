<?php

namespace App\Channels;

use App\Modules\Gotify\GotifyWrapper;
use Illuminate\Notifications\Notification;

class GotifyChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $gotify = app(GotifyWrapper::class);
        $gotify->sendMessage($notification->content, 'Thanks for using our service');
    }
}