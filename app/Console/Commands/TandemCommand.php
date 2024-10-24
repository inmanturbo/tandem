<?php

namespace Inmanturbo\Tandem\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;
use Inmanturbo\Tandem\Tandem;
use Inmanturbo\Tandem\TandemCommandHandler;

class TandemCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tandem {mod-name?} {vendor-namespace?} {app-namespace?} 
        {--install : Whether to install the mod to composer.json} 
        {--init : Whether to initialize the local mod repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up a new Laravel app with the specified namespace and vendor, to be used as a package or module.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Event::listen('*.info', function ($events, $payload): void {
            $this->output->write(implode('', $payload));
        });

        Event::listen('*.error', function (string $events, $payload): void {
            $this->error($events.': '.implode('', $payload));
        });

        Event::listen('*.warn', function (string $events, $payload): void {
            $this->warn($events.': '.implode('', $payload));
        });

        app(TandemCommandHandler::class)(new Tandem(
            $this->argument('mod-name'),
            $this->argument('app-namespace'),
            $this->argument('vendor-namespace'),
            $this->output->isVerbose(),
            $this->option('init'),
            $this->option('install'),
        ));

        return 0;
    }

    protected function laravel(): string
    {
        return 'laravel';
    }
}
