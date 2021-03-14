<?php

namespace Benborla\Hydra\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Benborla\Hydra\Http\Middleware\IsAValidTenant;
use Illuminate\Support\Facades\View;
use Benborla\Hydra\Resolvers\TenantResolver;
use Benborla\Hydra\Services\HydraPackageService;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('valid_tenant', IsAValidTenant::class);

        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'hydra');

        $this->app->booted(function () {
            $this->routes();
        });

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'hydra');

        Nova::serving(function (ServingNova $event) {
            Nova::script('hydra', __DIR__.'/../../dist/js/tool.js');
            Nova::style('hydra', __DIR__.'/../../dist/css/tool.css');
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Benborla\Hydra\Console\Commands\SyncPermissions::class
            ]);
        }

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->observers();

        $this->resolvers();
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['web'])
                ->namespace('hydra')
                ->domain(config('app.url'))
                ->group(__DIR__.'/../../routes/tenant.php');


        Route::middleware(['nova'])
                ->prefix('hydra')
                ->name('hydra.')
                ->group(__DIR__.'/../../routes/api.php');
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

    /**
     * @return void
     */
    protected function observers()
    {
    }

    protected function resolvers()
    {
        TenantResolver::handle($this->app, new HydraPackageService);
    }
}
