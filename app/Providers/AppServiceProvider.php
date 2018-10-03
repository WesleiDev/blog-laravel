<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Post;
use App\Observers\AuthorObserver;
use App\Observers\PostObserve;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Author::observe(AuthorObserver::class);
        Post::observe(PostObserve::class);
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
