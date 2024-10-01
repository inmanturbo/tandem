<?php

namespace Inmanturbo\Tandem\Actions;

use Illuminate\Support\Facades\File;

class InvokeEnsureDirectoryExists
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(EnsureDirectoryExists $action): void
    {
        File::ensureDirectoryExists($action->path);
    }
}
