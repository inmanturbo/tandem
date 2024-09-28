<?php

namespace Inmanturbo\Tandem\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Inmanturbo\Tandem\Actions\CopyFiles;
use Inmanturbo\Tandem\Actions\InstallMod;
use Inmanturbo\Tandem\ModInstall;
use Inmanturbo\Tandem\Tasks\ConfigureComposer;
use Inmanturbo\Tandem\Tasks\ReplaceNamespace;

use function Illuminate\Filesystem\join_paths;

class TandemCommand extends Command
{
    protected $signature = 'tandem {mod?} {vendor?} {namespace?} {--install : Whether to install the mod to composer.json} {--init : Whether to initialize the local repository}';

    protected $description = 'Sets up a new Laravel module with the specified namespace and vendor.';

    public function handle(): int
    {
        if (! File::exists(base_path('mod'))) {
            mkdir(base_path('mod'));
        }

        if ($this->option('init')) {
            $this->initializeModRepository();
        }

        if (! $this->argument('mod') || ! $this->argument('vendor') || ! $this->argument('namespace')) {
            if (! $this->option('init')) {
                $this->error('Please provide mod, vendor and namespace to create mod, or use --init option to initialize');
            }

            return 0;
        }

        if (! File::exists($this->buildPath())) {
            $this->info("Creating new Laravel module: {$this->argument('mod')}");

            $process = Process::path(base_path('mod'))->run([
                $this->laravel(),
                'new',
                $this->argument('mod'),
            ], function ($type, $buffer): void {
                $this->output->write($buffer);
            });

            if (! $process->successful()) {
                $this->error('Failed to create a new Laravel module.');

                return 1;
            }
        }

        Event::listen('copy-files.info', fn ($payload) => $this->info($payload['message']));

        app(InstallMod::class)->install(new ModInstall(
            $this->argument('mod'),
            $this->argument('namespace'),
            $this->argument('vendor'),
            $this->output->isVerbose(),
        ));

        $this->info('Running Composer commands...');

        $commands = [
            [
                $this->composer(),
                'require',
                '--dev',
                'rector/rector',
                'phpstan/phpstan',
            ],
            [
                $this->composer(),
                'config',
                'repositories.mod',
                $repositoryConfig = json_encode([
                    'type' => 'path',
                    'url' => '../*',
                    'options' => ['symlink' => false],
                ]),
                '--file',
                'composer.json',
            ],
            [
                $this->composer(),
                'config',
                'minimum-stability',
                'dev',
            ],
        ];

        foreach ($commands as $command) {
            $process = Process::path($this->buildPath())->run($command, function ($type, $buffer): void {
                $this->output->write($buffer);
            });

            if (! $process->successful()) {
                $this->error('Failed to run '.implode(' ', $command));

                return 1;
            }
        }

        $this->info('Module setup completed successfully.');

        if ($this->option('install')) {
            Process::run([
                $this->composer(),
                'require',
                "{$this->packageName()}:*",
            ], function ($type, $buffer): void {
                $this->output->write($buffer);
            });
        }

        return 0;
    }

    protected function composer(): string
    {
        return 'composer';
    }

    protected function laravel(): string
    {
        return 'laravel';
    }

    protected function composerFile()
    {
        return join_paths($this->modPath(), 'composer.json');
    }

    protected function fullyQualifiedNamespace(): string
    {
        return "{$this->argument('vendor')}\\{$this->argument('namespace')}";
    }

    protected function packageName(): string
    {
        return implode('/', [
            (string) Str::of($this->argument('vendor'))->kebab()->lower(),
            (string) Str::of($this->argument('mod'))->kebab()->lower(),
        ]);
    }

    protected function modPath(): string
    {
        return join_paths(base_path(), 'mod', $this->argument('mod'));
    }

    protected function stubPath()
    {
        return realpath(base_path('stubs/mod'));
    }

    protected function buildPath()
    {
        return realpath($this->modPath());
    }

    protected function initializeModRepository(): void
    {
        Process::run([
            $this->composer(),
            'config',
            'repositories.mod',
            $repositoryConfig = json_encode([
                'type' => 'path',
                'url' => 'mod/*',
                'options' => ['symlink' => true],
            ]),
            '--file',
            'composer.json',
        ], function ($type, $buffer): void {
            $this->output->write($buffer);
        });

        Process::run([
            $this->composer(),
            'config',
            'minimum-stability',
            'dev',
        ], function ($type, $buffer): void {
            $this->output->write($buffer);
        });

        $this->info('mod repository initialized');
    }
}
