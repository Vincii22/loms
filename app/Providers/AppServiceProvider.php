<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Observers\UserObserver;
use App\Models\User;
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
        Blade::component('student-sidebar', \App\View\Components\StudentSidebar::class);
        Blade::component('officer-sidebar', \App\View\Components\OfficerSidebar::class);
        Blade::component('admin-sidebar', \App\View\Components\AdminSidebar::class);
        User::observe(UserObserver::class);
    }
}
