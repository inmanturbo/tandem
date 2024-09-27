<?php

namespace Inmanturbo\Tandem\Actions;

use Illuminate\Support\Facades\File;

use function Illuminate\Filesystem\join_paths;

class CopyFiles
{
    public function copyFiles($from, $to, $verbose = false)
    {
        $this->info('Copying files...');

        if (! File::exists($from)) {
            $this->info('No files to copy!');

            return;
        }

        $files = File::allFiles($from, true);

        foreach ($files as $file) {
            $destinationFilePath = join_paths($to, $file->getRelativePathname());
            File::ensureDirectoryExists(dirname($destinationFilePath));
            File::copy($sourceFile = $file->getPathname(), $destinationFilePath);

            if ($verbose) {
                $this->info('<info>Copied</info> '.$sourceFile.' <info>to</info> '.$destinationFilePath);
            }
        }
    }

    protected function info($message)
    {
        event('copy-files.info', ['payload' => ['message' => $message]]);
    }
}
