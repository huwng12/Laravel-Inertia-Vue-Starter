<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\Listing\ListingRepositoryInterface;
use App\Repositories\Listing\ListingRepository;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Repositories\Profile\ProfileRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Notification\NotificationRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ListingRepositoryInterface::class, ListingRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Inertia::share('categories', function () {
            // Caching để giảm tải database nếu categories ít thay đổi
            return cache()->remember('categories', 60, function () {
                return Category::where('status', 1)->get(['id', 'name']); // Chỉ lấy các cột cần thiết
            });
        });
    }
}
