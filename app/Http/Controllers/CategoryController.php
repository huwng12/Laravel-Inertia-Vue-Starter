<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index($categoryId)
    {
        $listings = $this->categoryRepository->getCategories($categoryId, request(['search', 'user_id', 'tag']), 6);
        $category_name = Category::where('id', $categoryId)->first()->name;
        return inertia('Category/Show', [
            'listings' => $listings,
            'searchTerm' => request('search'),
            'category_name' => $category_name,
        ]);
    }
}
