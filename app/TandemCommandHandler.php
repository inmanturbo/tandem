<?php

namespace Inmanturbo\Tandem;

use Inmanturbo\Tandem\Actions\HandleTandem;
use Inmanturbo\Tandem\Actions\InvokeHandleTandem;

class TandemCommandHandler implements HandlesTandem
{
    protected function handlers():array
    {
        return [
            new EnsureTandemRepositoryPathExists,
            new InitializeTandemRepository,
            new InstallLaravelInTandem,
            new ReplaceInTandemFiles,
            new InstallStubs,
            new UpdateNamespaceInComposer,
            new RunComposerCommandsInTandem,
            new RequireNewTandemApp,
        ];
    }

    public function __invoke(Tandem $tandem): void
    {
        app(InvokeHandleTandem::class)(new HandleTandem($tandem, ...$this->handlers()));
    }
}
