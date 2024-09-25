<?php

namespace Inmanturbo\Tandem\Concerns;

use Illuminate\Support\Facades\File;

trait InstallsStubs
{
    abstract protected function stubPath();

    abstract protected function buildPath();

    protected function copyFiles()
    {
        $this->info('Copying files...');

        $sourceDir = $this->stubPath();
        $destinationDir = $this->buildPath();

        if (! File::exists($sourceDir)) {
            if (app()->runningInConsole()) {
                $this->info('No files to copy!');
            }

            return;
        }

        $files = File::allFiles($sourceDir, true);

        foreach ($files as $file) {
            $destinationFilePath = $destinationDir.'/'.$file->getRelativePathname();
            File::ensureDirectoryExists(dirname($destinationFilePath));
            File::copy($sourceFile = $file->getPathname(), $destinationFilePath);

            if (app()->runningInConsole() && $this->output->isVerbose()) {
                $this->line('<info>Copied</info> '.$sourceFile.' <info>to</info> '.$destinationFilePath);
            }
        }
    }
}
