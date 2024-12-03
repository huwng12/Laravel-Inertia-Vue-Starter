<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotSuspended;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $listings = Listing::whereHas('user', function (Builder $query) {
        //     $query->where('role', '!=', 'suspended');
        // })->with('user')
        //     ->where('approved', true)
        //     ->filter(request(['search', 'user_id', 'tag']))
        //     ->latest()
        //     ->paginate(6)
        //     ->withQueryString();

        $listings = $this->listingRepository->getAllListings(request(['search', 'user_id', 'tag']), 6);

        return inertia('Home', [
            'listings' => $listings,
            'searchTerm' => request('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize(('create'), Listing::class);
        return inertia('Listings/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize(('create'), Listing::class);

        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'desc' => ['required'],
            'tags' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'link' => ['nullable', 'url'],
            'image' => ['nullable', 'file', 'max:3072', 'mimes:jpeg,jpg,png,webp'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        $this->listingRepository->createListing($fields, $request->file('image'), $fields['tags'], $request->user());

        return redirect()->route('dashboard')->with('status', 'Listing created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);

        return inertia('Listings/Show', [
            'listing' => $listing,
            'user' => $listing->user->only('name', 'id'),
            'canModify' => Auth::user() ? Auth::user()->can('modify', $listing) : null,
            'comments' => $listing->comments()->where('status', '1')->latest()->get(),
            'status' => session('status'),
            'category_name' => $listing->getCategoryName(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize(('modify'), $listing);

        return inertia('Listings/Edit', [
            'listing' => $listing,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        Gate::authorize(('modify'), $listing);
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'desc' => ['required'],
            'tags' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'link' => ['nullable', 'url'],
            'image' => ['nullable', 'file', 'max:3072', 'mimes:jpeg,jpg,png,webp'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        $this->listingRepository->updateListing($listing->id, $fields, $request->file('image'), $fields['tags']);

        return redirect()->route('dashboard')->with('status', 'Listing updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize(('modify'), $listing);

        $this->listingRepository->deleteListing($listing->id);
        return redirect()->route('dashboard')->with('status', 'Listing deleted successfully.');
    }
}
