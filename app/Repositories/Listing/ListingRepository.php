<?php

namespace App\Repositories\Listing;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ListingRepository implements ListingRepositoryInterface
{
    public function getAllListings(array $filters, int $perPage): LengthAwarePaginator
    {
        return Listing::whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })->with('user', 'comments')
            ->where('approved', true)
            ->filter($filters)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getHotNewsListings()
    {
        $hot_news = Listing::whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })->with('user', 'comments')
            ->where('approved', true)
            ->orderByDesc('view')
            ->limit(3)
            ->get();
        return $hot_news;
    }

    public function createListing(array $fields, $image = null, $tags = null, $user)
    {
        if ($image) {
            $fields['image'] = Storage::disk('public')->put('images/listing', $image);
        }

        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',',  $tags)))));
        // dd($fields);
        return $user->listings()->create($fields);
    }

    public function updateListing(int $listingId, array $fields, $image = null, $tags = null)
    {
        $listing = Listing::find($listingId);
        if (!$listing) {
            return false;
        }
        if ($image) {
            if ($listing->image) {
                Storage::disk('public')->delete($listing->image);
            }
            $fields['image'] = Storage::disk('public')->put('images/listing', $image);
        } else {
            $fields['image'] = $listing->image;
        }

        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',',  $tags)))));
        return $listing->update([...$fields, 'approved' => false]);
    }

    public function updateListingStatus(int $listingId)
    {
        $listing = Listing::find($listingId);
        if (!$listing) {
            return false;
        }
        return $listing->update(['approved' => !$listing->approved]);
    }

    public function deleteListing(int $listingId)
    {
        $listing = Listing::find($listingId);
        if (!$listing) {
            return false;
        }
        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }
        return $listing->delete();
    }
}
