<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public $notificationRepository;
    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function show()
    {
        $notifications = $this->notificationRepository->getNotifications(5);
        return response()->json($notifications);
    }

    public function updateNotificationIsRead(Request $request)
    {
        $this->notificationRepository->updateNotificationIsRead($request->id);
        return back()->with('status', 'Notification updated successfully');
    }
}
