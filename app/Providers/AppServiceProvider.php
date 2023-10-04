<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\HumanResources\Attendance\Application\AttendanceService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AttendanceService::class, function ($app) {
            return new AttendanceService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
