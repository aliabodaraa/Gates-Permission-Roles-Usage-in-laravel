<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;//important call
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('tasks_create',function(User $user){ return $user->is_admin;});
        Gate::define('tasks_edit',function(User $user){ return $user->is_admin;});
        Gate::define('tasks_delete',function(User $user){ return $user->is_admin;});
    }
}
