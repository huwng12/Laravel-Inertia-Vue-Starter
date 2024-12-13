<?php

namespace App\Repositories\Notification;

use App\Events\NotificationCreated;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function createNotification(array $fields)
    {
        $fields['from_user_id'] = Auth::id();
        $fields['type'] = 1;
        $userId = Auth::id();

        if ($fields['user_id'] == 0) {
            $userIds = User::where('id', '!=', $userId)->pluck('id')->toArray();
            foreach ($userIds as $id) {
                $fields['user_id'] = $id;
                Notification::create($fields);
                broadcast(new NotificationCreated($fields, $id));
            }
        } else {
            Notification::create($fields);
            broadcast(new NotificationCreated($fields, $fields['user_id']));
        }
        // Notification::create($fields);
        // if()
        // broadcast(new NotificationCreated($fields, $userId));
    }

    public function getNotifications()
    {
        $notification = Auth::user()->notifications()->latest()->paginate(30);
        return $notification;
    }

    public function updateNotificationIsRead(int $id)
    {
        $notification = Notification::find($id);
        $notification->is_read = 1;
        $notification->save();
    }
}
