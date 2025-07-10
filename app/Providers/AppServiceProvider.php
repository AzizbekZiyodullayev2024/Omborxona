<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Role\Contracts\iRoleService;
use App\Services\Role\RoleService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(iRoleService::class, RoleService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
