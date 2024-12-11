<?php

namespace App\Repositories\Notification;

use App\Events\NotificationCreated;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function createNotification(array $fields)
    {
        $fields['from_user_id'] = Auth::id();
        $userId = Auth::id();
        Notification::create($fields);
        broadcast(new NotificationCreated($fields, $userId));
    }

    public function getNotifications()
    {
        $notification = Auth::user()->notifications()->latest()->paginate(30);
        return $notification;
    }
}
