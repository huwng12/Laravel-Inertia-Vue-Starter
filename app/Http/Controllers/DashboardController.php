<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role === 'admin') {
            $listings = Listing::filter(request(['disapproved']))->latest()->paginate(10);
        } else if ($request->user()->role !== 'suspended') {
            $listings = $request->user()->listings()->filter(request(['disapproved']))->latest()->paginate(10);
        } else {
            $listings = null;
        }
        return inertia('Dashboard', [
            'listings' => $listings,
            'status' => session('status'),
        ]);
    }
}
