<?php

namespace Inmanturbo\Tandem\Providers;

use Illuminate\Support\ServiceProvider;
use Inmanturbo\Tandem\Console\Commands\TandemCommand;

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
        if ($this->app->runningInConsole()) {
            $this->commands([
                TandemCommand::class,
            ]);
        }
    }
}
