<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getCategories(string $categoryId, array $filters, int $perPage): LengthAwarePaginator
    {
        return Listing::whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })->when($categoryId, function ($query, $categoryId) {
            $query->whereHas('category', function ($query) use ($categoryId) {
                $query->where('id', $categoryId);
            });
        })
            ->with('user', 'category')
            ->where('approved', true)
            ->filter($filters)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
