<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\PasswordConfirmationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    //Get Notification
    Route::get('/notification', [NotificationController::class, 'show'])->name('notification.show');
    Route::put('/notification/{id}', [NotificationController::class, 'updateNotificationIsRead'])->name('notification.update');

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



//Admin routes
Route::middleware(['auth', 'verified', Admin::class])
    ->controller(AdminController::class)
    ->group(function () {
        Route::get('/admin', 'index')->name('admin.index');
        Route::get('/users/{user}', 'show')->name('user.show');
        Route::put('/admin/{user}/role', 'role')->name('admin.role');
        Route::put('/listings/{listing}/approve', 'approve')->name('admin.approve');

        Route::get('/notifications', 'indexNotification')->name('notification.index');
        Route::post('/notifications', 'storeNotification')->name('notification.store');
    });

//Listing Category
Route::middleware(['auth', 'verified', Admin::class])
    ->controller(CategoryController::class)
    ->group(function () {
        Route::get('/category', 'list')->name('category.list');
        Route::get('/category/create', 'create')->name('category.create');
        Route::post('/category/create', 'store')->name('category.store');
        Route::put('/category/active/{categoryId}', 'active')->name('category.active');
        Route::delete('/category/delete/{categoryId}', 'delete')->name('category.delete');
        Route::get('/category/{categoryId}', 'index')->where('categoryId', '[0-9]+')->name('category.index');
        Route::put('/category/edit/{categoryId}', 'edit')->name('category.edit');
    });

//Auth routes
require __DIR__ . '/auth.php';
