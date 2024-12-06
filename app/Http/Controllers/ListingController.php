<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotSuspended;
use App\Http\Requests\Listing\UpdateListingRequest;
use App\Models\Listing;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Listing\ListingRepositoryInterface;

class ListingController extends Controller implements HasMiddleware
{
    private $listingRepository;

    public function __construct(ListingRepositoryInterface $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    public static function middleware()
    {
        return [new Middleware(['auth', 'verified', NotSuspended::class], except: ['index', 'show'])];
    }


    public function index()
    {
        $listings = $this->listingRepository->getAllListings(request(['search', 'user_id', 'tag']), 6);
        $hot_news = $this->listingRepository->getHotNewsListings();
        return inertia('Home', [
            'listings' => $listings,
            'searchTerm' => request('search'),
            'hot_news' => $hot_news,
        ]);
    }

    public function create()
    {
        Gate::authorize(('create'), Listing::class);
        return inertia('Listings/Create');
    }

    public function store(UpdateListingRequest $request)
    {
        Gate::authorize(('create'), Listing::class);
        $fields = $request->validated();
        $this->listingRepository->createListing($fields, $request->file('image'), $fields['tags'], $request->user());
        return redirect()->route('dashboard')->with('status', 'Listing created successfully.');
    }

    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);
        $listing->increment('view');
        return inertia('Listings/Show', [
            'listing' => $listing,
            'user' => $listing->user->only('name', 'id'),
            'canModify' => Auth::user() ? Auth::user()->can('modify', $listing) : null,
            'comments' => $listing->comments()->where('status', '1')->latest()->get(),
            'status' => session('status'),
            'category_name' => $listing->getCategoryName(),
        ]);
    }

    public function edit(Listing $listing)
    {
        Gate::authorize(('modify'), $listing);
        return inertia('Listings/Edit', [
            'listing' => $listing,
        ]);
    }

    public function update(UpdateListingRequest $request, Listing $listing)
    {
        Gate::authorize(('modify'), $listing);
        $fields = $request->validated();
        $this->listingRepository->updateListing($listing->id, $fields, $request->file('image'), $fields['tags']);
        return redirect()->route('dashboard')->with('status', 'Listing updated successfully.');
    }

    public function destroy(Listing $listing)
    {
        Gate::authorize(('modify'), $listing);
        $this->listingRepository->deleteListing($listing->id);
        return redirect()->route('dashboard')->with('status', 'Listing deleted successfully.');
    }
}
