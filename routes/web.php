<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\PasswordConfirmationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'updateInfo'])->name('profile.info');
    Route::put('/profile', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/comment/{listing}', [CommentController::class, 'store'])->name('comment.store');
});

//Listing routes
Route::get('/', [ListingController::class, 'index'])->name('home');
Route::resource('listings', ListingController::class)->except('index');

//Listing Category
Route::get('/category', [CategoryController::class, 'list'])->name('category.list');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');
Route::put('/category/active/{categoryId}', [CategoryController::class, 'active'])->name('category.active');
Route::delete('/category/delete/{categoryId}', [CategoryController::class, 'delete'])->name('category.delete');
Route::get('/category/{categoryId}', [CategoryController::class, 'index'])->where('categoryId', '[0-9]+')->name('category.index');

//Admin routes
Route::middleware(['auth', 'verified', Admin::class])
    ->controller(AdminController::class)
    ->group(function () {
        Route::get('/admin', 'index')->name('admin.index');
        Route::get('/users/{user}', 'show')->name('user.show');
        Route::put('/admin/{user}/role', 'role')->name('admin.role');
        Route::put('/listings/{listing}/approve', 'approve')->name('admin.approve');
    });



//Auth routes
require __DIR__ . '/auth.php';
