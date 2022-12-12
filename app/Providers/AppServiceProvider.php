<?php

namespace App\Providers;

use App\Repositories\Post\PostRepository;
use App\Repositories\Post\IPostRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind(PostRepository::class, IPostRepository::class);
        $this->app->bind(CategoryRepository::class, ICategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
