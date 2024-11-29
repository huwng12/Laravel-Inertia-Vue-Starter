<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Chia sẻ categories toàn cục
        Inertia::share('categories', function () {
            // Caching để giảm tải database nếu categories ít thay đổi
            return cache()->remember('categories', 60, function () {
                return Category::where('status', 1)->get(['id', 'name']); // Chỉ lấy các cột cần thiết
            });
        });
    }
}
