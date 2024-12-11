<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Http\Requests\Admin\NotificationRequest;
use App\Models\Listing;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Listing\ListingRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    private $userRepository;
    private $listingRepository;
    private $notificationRepository;

    public function __construct(UserRepositoryInterface $userRepository, ListingRepositoryInterface $listingRepository, NotificationRepositoryInterface $notificationRepository)
    {
        $this->userRepository = $userRepository;
        $this->listingRepository = $listingRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAllUsers(request(['search', 'role']), 5);
        return inertia('Admin/AdminDashboard', [
            'users' => $users,
            'status' => session('status')
        ]);
    }

    public function show(User $user)
    {
        $user_listings = $this->userRepository->getUserListings($user->id, request(['search', 'disapproved']), 5);
        return inertia('Admin/UserPage', [
            'user' => $user,
            'listings' => $user_listings,
            'status' => session('status')
        ]);
    }

    public function role(UpdateRoleRequest $request, User $user)
    {
        $this->userRepository->updateRole($user->id, $request->role);
        return redirect()->route('admin.index')->with(
            'status',
            "User's role changed to {$request->role} successfully"
        );
    }

    public function approve(Listing $listing)
    {
        $this->listingRepository->updateListingStatus($listing->id);
        $msg = $listing->approved ? 'approved' : 'disapproved';
        return back()->with('status', "Listing {$msg} successfully");
    }

    // Notifications
    public function indexNotification()
    {
        $users = $this->userRepository->getAllUsersExceptAdmin(request(['search', 'role']), null);
        return inertia('Admin/SendNotification', ['users' => $users, 'status' => session('status')]);
    }

    public function storeNotification(NotificationRequest $request)
    {
        $this->notificationRepository->createNotification(request(['user_id', 'title', 'message']));
        return redirect()->route('notification.index')->with('status', 'Notification sent successfully');
    }

    public function showNotification(User $user)
    {
        $notification = $this->notificationRepository->getNotifications();
        return inertia('Admin/ShowNotification', ['user' => $user, 'notification' => $notification]);
    }
}
