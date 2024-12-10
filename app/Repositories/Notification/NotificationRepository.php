<?php

namespace App\Repositories\Notification;

use App\Events\NotificationCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function createNotification(array $fields)
    {
        // dd($fields);
        Auth::user()->notifications()->create($fields);
        broadcast(new NotificationCreated($fields));
    }
}
