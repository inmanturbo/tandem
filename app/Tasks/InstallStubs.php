<?php

namespace Inmanturbo\Tandem\Tasks;

use Inmanturbo\Tandem\Actions\CopyFiles;
use Inmanturbo\Tandem\ModInstall;

class InstallStubs
{
    public function __invoke(ModInstall $mod): void
    {
        app(CopyFiles::class)($mod->stubPath(), $mod->basePath(), $mod->isVerbose);
    }
}
