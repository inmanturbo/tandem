<?php

namespace Inmanturbo\Tandem;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Inmanturbo\Tandem\Actions\InstallLaravel;
use Inmanturbo\Tandem\Actions\InvokeInstallLaravel;
use Inmanturbo\Tandem\Actions\InvokeOutput;
use Inmanturbo\Tandem\Actions\Output;

class InstallLaravelInTandem implements HandlesTandem
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(Tandem $tandem): void
    {
        if (File::exists($tandem->basePath())) {
            return;
        }

        $process = app(InvokeInstallLaravel::class)(new InstallLaravel($tandem->repositoryPath(), Arr::wrap($tandem->laravel()), [
            'new',
            $tandem->modName(),
        ],
            function (string $type, string $output): void {
                app(InvokeOutput::class)(new Output($output));
            }
        ));

        if (! $process->successful()) {
            app(InvokeOutput::class)(new Output('Failed to create a new Laravel module.', 'tandem.error'));
        }
    }
}
