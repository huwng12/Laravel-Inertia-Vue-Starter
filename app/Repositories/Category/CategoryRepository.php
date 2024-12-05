<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

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

    public function getAllCategories(array $filters, int $perPage): LengthAwarePaginator
    {
        return Category::when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->latest()->paginate($perPage)->withQueryString();
    }


    public function createCategory(array $fields): void
    {
        $fields['status'] = 0;
        Category::create($fields);
    }

    public function activeCategory(string $categoryId): void
    {
        $category = Category::where('id', $categoryId)->first();
        $category->update(['status' => !$category->status]);
        Cache::forget('categories'); //xóa cache để lấy dữ liệu mới cập nhật cho main layout
    }

    public function deleteCategory(string $categoryId): void
    {
        Category::where('id', $categoryId)->delete();
        Cache::forget('categories'); //xóa cache để lấy dữ liệu mới cập nhật cho main layout

    }
}
