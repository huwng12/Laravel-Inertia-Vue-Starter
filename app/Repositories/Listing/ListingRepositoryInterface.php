<?php

namespace App\Repositories\Listing;

use Illuminate\Pagination\LengthAwarePaginator;

interface ListingRepositoryInterface
{
    public function getAllListings(array $filters, int $perPage): LengthAwarePaginator;

    public function createListing(array $fields, $image = null, $tags = null, $user);

    public function updateListing(int $listingId, array $fields, $image = null, $tags = null);

    public function updateListingStatus(int $listingId);

    public function deleteListing(int $listingId);
}
