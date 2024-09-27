<?php

namespace Inmanturbo\Tandem\Providers;

use Illuminate\Support\ServiceProvider;
use Inmanturbo\Tandem\Actions\FindFilesByPattern;
use Inmanturbo\Tandem\Console\Commands\TandemCommand;
use Inmanturbo\Tandem\Contracts\FileGlob as FileGlobContract;
use Inmanturbo\Tandem\Contracts\FindsFilesByFilepathPattern;
use Inmanturbo\Tandem\Contracts\FindsFilesByPattern;
use Inmanturbo\Tandem\FileGlob;
use Inmanturbo\Tandem\SimpleGlobPatternFileFinder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FileGlobContract::class, FileGlob::class);
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
