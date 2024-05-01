<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;

class NotificationHelper
{
    public static function createNotificationForUser($user, $title, $body)
    {
        $notification = new Notification([
            'title' => $title,
            'body' => $body,
        ]);

        $user->notifications()->save($notification);

        return $notification;
    }
}