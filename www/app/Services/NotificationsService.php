<?php

namespace App\Services;

use App\Models\Notification;

class NotificationsService
{
    public function createNotification($userId, $sender, $event_name, $message): void
    {
        Notification::create([
            'user_id' => $userId,
            'sender' => $sender,
            'event_name' => $event_name,
            'message' => $message,
            'read' => false
        ]);
    }

    public function deleteNotification($id): void
    {
        Notification::destroy($id);
    }
}
