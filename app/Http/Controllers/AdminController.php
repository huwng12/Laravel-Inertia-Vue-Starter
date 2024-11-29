<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('listings')
            ->filter(request(['search', 'role']))
            ->paginate(5)
            ->withQueryString();
        return inertia('Admin/AdminDashboard', [
            'users' => $users,
            'status' => session('status')
        ]);
    }

    public function show(User $user)
    {
        $user_listings = $user->listings()
            ->userListingForAdminFilter(request(['search', 'disapproved']))
            ->latest()
            ->paginate(5)
            ->withQueryString();
        // dd($user_listings);
        return inertia('Admin/UserPage', [
            'user' => $user,
            'listings' => $user_listings,
            'status' => session('status')
        ]);
    }

    public function role(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string'
        ]);
        $user->update(['role' => $request->role]);

        return redirect()->route('admin.index')->with(
            'status',
            "User's role changed to {$request->role} successfully"
        );
    }

    public function approve(Listing $listing)
    {
        $listing->update(['approved' => !$listing->approved]);
        $msg = $listing->approved ? 'approved' : 'disapproved';
        return back()->with('status', "Listing {$msg} successfully");
    }
}
