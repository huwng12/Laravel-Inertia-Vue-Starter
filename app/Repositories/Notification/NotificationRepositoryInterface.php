<?php

namespace App\Repositories\Notification;

use Illuminate\Pagination\LengthAwarePaginator;

interface NotificationRepositoryInterface
{
    public function createNotification(array $fields);
}
