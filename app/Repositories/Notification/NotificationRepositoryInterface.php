<?php

namespace App\Repositories\Notification;


interface NotificationRepositoryInterface
{
    public function createNotification(array $fields);

    public function getNotifications();

    public function updateNotificationIsRead(int $id);
}
