<?php

namespace App\Repositories\Category;

use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function getCategories(string $categoryId, array $filters, int $perPage): LengthAwarePaginator;
}
