<?php

namespace Inmanturbo\Tandem\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Inmanturbo\Tandem\Concerns\InstallsStubs;

class TandemCommand extends Command
{
    use InstallsStubs;

    protected $signature = 'tandem {mod} {vendor} {namespace} {--install : Whether to install the mod to composer.json} {--init : Whether to initialize the local repository}';

    protected $description = 'Sets up a new Laravel module with the specified namespace and vendor.';

    public function handle(): int
    {
        $moduleName = $this->argument('mod');
        $packageVendor = $this->argument('vendor');
        $packageNamespace = $this->argument('namespace');
        $fqns = "{$packageVendor}\\{$packageNamespace}";
        $path = "mod/{$moduleName}";

        if (! File::exists(base_path('mod'))) {
            mkdir(base_path('mod'));
        }

        if ($this->option('init')) {
            Process::run("composer config repositories.mod '{\"type\": \"path\", \"url\": \"mod/*\", \"options\": {\"symlink\": true}}' --file composer.json && composer config minimum-stability 'dev'");
        }

        if (! File::exists($path)) {
            $this->info("Creating new Laravel module: {$moduleName}");

            $process = Process::run("cd mod && laravel new {$moduleName}", function ($type, $buffer): void {
                $this->output->write($buffer);
            });

            if (! $process->successful()) {
                $this->error('Failed to create a new Laravel module.');

                return 1;
            }
        }

        $this->copyFiles();

        $phpFiles = File::allFiles($path, true);
        foreach ($phpFiles as $file) {
            $filePath = $file->getRealPath();
            $this->replaceNamespace($filePath, $packageVendor, $packageNamespace);
        }

        $packageName = Str::of($packageVendor)->kebab()->lower()->__toString()
            .'/'
            .Str::of($packageNamespace)->kebab()->lower()->__toString();

        $this->updateComposerJson($path, $fqns, $packageName);

        $this->info('Running Composer commands...');
        $process = Process::run("(cd {$path} && composer require --dev rector/rector phpstan/phpstan && composer config repositories.mod '{\"type\": \"path\", \"url\": \"../*\", \"options\": {\"symlink\": false}}' --file composer.json && composer config minimum-stability 'dev')", function ($type, $buffer): void {
            $this->output->write($buffer);
        });

        if (! $process->successful()) {
            $this->error('Failed to run Composer commands.');

            return 1;
        }

        $this->info('Module setup completed successfully.');

        if ($this->option('install')) {
            Process::run("composer require $packageName:*", function ($type, $buffer): void {
                $this->output->write($buffer);
            });
        }

        return 0;
    }

    protected function replaceNamespace($filePath, $packageVendor, $packageNamespace)
    {
        $content = File::get($filePath);

        $content = str_replace('namespace App', "namespace {$packageVendor}\\{$packageNamespace}", $content);
        $content = str_replace('use App', "use {$packageVendor}\\{$packageNamespace}", $content);
        $content = str_replace('use Database', "use {$packageVendor}\\{$packageNamespace}\\Database", $content);
        $content = str_replace(' App\\', " {$packageVendor}\\{$packageNamespace}\\", $content);
        $content = str_replace('namespace Database\\', "namespace {$packageVendor}\\{$packageNamespace}\\Database\\", $content);

        File::put($filePath, $content);
    }

    protected function updateComposerJson($path, $fqns, $name)
    {
        $composerJsonPath = "{$path}/composer.json";
        $composerData = json_decode(File::get($composerJsonPath), true);

        unset($composerData['autoload']['psr-4']);

        $composerData['autoload']['psr-4']["{$fqns}\\Database\\Factories\\"] = 'database/factories/';
        $composerData['autoload']['psr-4']["{$fqns}\\Database\\Seeders\\"] = 'database/seeders/';
        $composerData['autoload']['psr-4']["{$fqns}\\"] = 'app/';

        $composerData['name'] = $name;

        if (! isset($composerData['extra']['laravel']['providers'])) {
            $composerData['extra']['laravel']['providers'] = [];
        }
        $composerData['extra']['laravel']['providers'][] = "{$fqns}\\Providers\\AppServiceProvider";

        File::put($composerJsonPath, json_encode($composerData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    protected function stubPath()
    {
        return realpath(base_path('stubs/mod'));
    }

    protected function buildPath()
    {
        $moduleName = $this->argument('mod');

        return realpath($path = "mod/{$moduleName}");
    }
}
