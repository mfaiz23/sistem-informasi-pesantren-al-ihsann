<?php

namespace App\Providers;

use App\Models\Formulir;
use App\Policies\FormulirPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Formulir::class => FormulirPolicy::class,
    ];

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
        app()->setLocale(env('APP_LOCALE', config('app.locale')));
    }
}
