<?php

namespace App\Repositories\Category;

use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function getCategories(string $categoryId, array $filters, int $perPage): LengthAwarePaginator;

    public function getAllCategories(array $filters, int $perPage): LengthAwarePaginator;

    public function createCategory(array $fields): void;

    public function activeCategory(string $categoryId): void;

    public function deleteCategory(string $categoryId): void;

    public function editCategory(array $fields, int $categoryId): void;
}
