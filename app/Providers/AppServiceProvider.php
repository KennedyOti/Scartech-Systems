<?php

namespace App\Providers;

use App\Models\Service;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Paginator::defaultView('components.pagination');

        Blade::anonymousComponentPath(resource_path('views/portal/components'), 'portal');

        View::share('company', config('company'));

        View::composer(['components.site-header', 'components.site-footer'], function ($view): void {
            $view->with('navServices', once(
                fn () => Service::active()->ordered()->get(['id', 'name', 'slug', 'icon', 'tagline'])
            ));
        });

        Str::macro('telHref', fn (string $phone): string => 'tel:'.preg_replace('/[^\d+]/', '', $phone));
    }
}
