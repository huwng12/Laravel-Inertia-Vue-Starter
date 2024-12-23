<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;

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

    public function list()
    {
        $categoryList = $this->categoryRepository->getAllCategories(request(['search', 'user_id', 'tag']), 10);
        return inertia('Category/List', [
            'categoryList' => $categoryList,
            'status' => session('status')
        ]);
    }

    public function create()
    {
        return inertia('Category/Create');
    }

    public function active($categoryId)
    {
        $this->categoryRepository->activeCategory($categoryId);
        return redirect()->route('category.list')->with('status', 'Category status updated successfully');
    }

    public function delete($categoryId)
    {
        $this->categoryRepository->deleteCategory($categoryId);
        return redirect()->route('category.list')->with('status', 'Category deleted successfully');
    }

    public function store(StoreCategoryRequest $request)
    {
        $fields = $request->validated();

        $this->categoryRepository->createCategory($fields);
        return redirect()->route('category.list')->with('status', 'Category created successfully');
    }

    public function edit(StoreCategoryRequest $request)
    {
        $fields = $request->validated();
        $this->categoryRepository->editCategory($fields, $request->categoryId);
        // return inertia('Category/List', [
        //     'status' => 'Category updated successfully',
        // ]);
        return redirect()->route('category.list')->with('status', 'Category updated successfully');
    }
}
