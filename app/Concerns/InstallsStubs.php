<?php

namespace Inmanturbo\Tandem\Concerns;

use Illuminate\Support\Facades\File;

use function Illuminate\Filesystem\join_paths;

trait InstallsStubs
{

    protected function installStubs($stubPath, $installPath)
    {
        if (app()->runningInConsole()) {
            $this->info('Copying files...');
        }

        if (! File::exists($stubPath)) {
            if (app()->runningInConsole()) {
                $this->info('No files to copy!');
            }

            return;
        }

        $files = File::allFiles($stubPath, true);

        foreach ($files as $file) {
            $destinationFilePath = join_paths($installPath, $file->getRelativePathname());
            File::ensureDirectoryExists(dirname($destinationFilePath));
            File::copy($sourceFile = $file->getPathname(), $destinationFilePath);

            if (app()->runningInConsole() && $this->output->isVerbose()) {
                $this->line('<info>Copied</info> '.$sourceFile.' <info>to</info> '.$destinationFilePath);
            }
        }
    }
}
