<?php

namespace App\Services;

use App\Models\Notification;

class NotificationsService
{
    public function createNotification($userId, $event_name, $message): void
    {
        Notification::create([
            'user_id' => $userId,
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
