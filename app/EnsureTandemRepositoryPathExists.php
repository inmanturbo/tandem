<?php

namespace Inmanturbo\Tandem;

use Inmanturbo\Tandem\Actions\EnsureDirectoryExists;
use Inmanturbo\Tandem\Actions\InvokeEnsureDirectoryExists;

class EnsureTandemRepositoryPathExists implements HandlesTandem
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(Tandem $tandem): void
    {
        app(InvokeEnsureDirectoryExists::class)(new EnsureDirectoryExists($tandem->repositoryPath()));
    }
}
