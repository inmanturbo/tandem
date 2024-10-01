<?php

namespace Inmanturbo\Tandem\Actions;

use Illuminate\Support\Facades\File;

use function Illuminate\Filesystem\join_paths;

class InvokeCopyFiles
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(CopyFiles $action): void
    {
        if (! File::exists($action->from)) {
            app(InvokeOutput::class)(new Output('No files to copy!', 'file-copy.warn'));

            return;
        }

        foreach (File::allFiles($action->from) as $file) {
            $destinationFilePath = join_paths($action->to, $file->getRelativePathname());
            File::ensureDirectoryExists(dirname($destinationFilePath));
            File::copy($sourceFile = $file->getPathname(), $destinationFilePath);

            app(InvokeOutput::class)(new Output($sourceFile.'->'.$destinationFilePath.PHP_EOL, 'file-copy.info'));
        }
    }
}
