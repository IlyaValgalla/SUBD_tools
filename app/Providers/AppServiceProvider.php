<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

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
    public function boot(): void
    {
        Paginator::defaultView('pagination::default');

        Gate::define('destroy-equipment', function (User $user){
           return $user->is_admin;
        });

        Gate::define('create-equipment', function (User $user){
            return $user->is_admin;
        });

        Gate::define('update-equipment', function (User $user) {
            return $user->is_admin;
        });
        ////////////
        ///
        /// ////
        Gate::define('destroy-category', function (User $user){
            return $user->is_admin;
        });

        Gate::define('create-category', function (User $user){
            return $user->is_admin;
        });

        Gate::define('update-category', function (User $user){
            return $user->is_admin;
        });
        ///////////
        ///
        /// ///
        Gate::define('index-user', function (User $user){
            return $user->is_admin;
        });

        Gate::define('show-user', function (User $user){
            return $user->is_admin;
        });

        Gate::define('index-rental', function (User $user){
            return $user->is_admin;
        });
    }
}
