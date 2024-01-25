<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\UserNotification;
use App\Models\User;

class SendNotificationToUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        /*
        $admins = User::whereHas('roles', function ($query) {
            $query->where('id', 1);
        })->get();
        */
        $admins = User::all();
        \Notification::send($admins, new UserNotification($event->user));
    }
}
