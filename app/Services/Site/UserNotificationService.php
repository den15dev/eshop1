<?php

namespace App\Services\Site;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection as ECollection;

class UserNotificationService
{
    private static int|null $unread_num = null;


    public function get(int $user_id): ECollection
    {
        $notifications = Notification::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        if (self::$unread_num === null) {
            self::$unread_num = $notifications->where('is_unread', 1)->count();
        }

        return $notifications;
    }


    public function getUnreadNum(int $user_id): int
    {
        if (self::$unread_num === null) {
            self::$unread_num = Notification::where('user_id', $user_id)->where('is_unread', 1)->count();
        }

        return self::$unread_num;
    }


    public function getUnreadReport(int $unread_num): string
    {
        $report = 'Нет непрочитанных';

        if ($unread_num) {
            $report = trans_choice(
                implode('|', [
                    ':count непрочитанное',
                    ':count непрочитанных',
                    ':count непрочитанных'
                ]),
                $unread_num
            );
        }

        return $report;
    }


    public function markAsRead(int $notification_id, int $user_id): int
    {
        Notification::where('id', $notification_id)->update(['is_unread' => 0]);

        return $this->getUnreadNum($user_id);
    }


    public function markAllAsRead(int $user_id): void
    {
        Notification::where('user_id', $user_id)->where('is_unread', 1)->update(['is_unread' => 0]);
    }
}
