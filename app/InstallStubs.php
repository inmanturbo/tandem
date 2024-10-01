<?php

namespace Inmanturbo\Tandem;

use Inmanturbo\Tandem\Actions\CopyFiles;
use Inmanturbo\Tandem\Actions\InvokeCopyFiles;

class InstallStubs implements HandlesTandem
{
    public function __invoke(Tandem $tandem): void
    {
        if (! $tandem->basePath()) {
            return;
        }

        app(InvokeCopyFiles::class)(new CopyFiles($tandem->stubPath(), $tandem->basePath()));
    }
}
