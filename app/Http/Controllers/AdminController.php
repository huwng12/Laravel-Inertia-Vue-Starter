<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Models\Listing;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Listing\ListingRepositoryInterface;

class AdminController extends Controller
{
    private $userRepository;
    private $listingRepository;

    public function __construct(UserRepositoryInterface $userRepository, ListingRepositoryInterface $listingRepository)
    {
        $this->userRepository = $userRepository;
        $this->listingRepository = $listingRepository;
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
}
