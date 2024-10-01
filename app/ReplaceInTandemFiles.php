<?php

namespace Inmanturbo\Tandem;

use Inmanturbo\Tandem\Actions\InvokeFindReplaceInFiles;
use Inmanturbo\Tandem\Actions\ReplaceAppModelsUserInAuthConfig;
use Inmanturbo\Tandem\Actions\ReplaceNamespaceApp;
use Inmanturbo\Tandem\Actions\ReplaceNamespaceDatabase;
use Inmanturbo\Tandem\Actions\ReplaceUseApp;
use Inmanturbo\Tandem\Actions\ReplaceUseDatabase;

class ReplaceInTandemFiles implements HandlesTandem
{
    protected function replacers(Tandem $tandem): array
    {
        return [
            new ReplaceNamespaceApp($tandem->basePath(), $tandem->fullyQualifiedNamespace()),
            new ReplaceNamespaceDatabase($tandem->basePath(), $tandem->fullyQualifiedNamespace()),
            new ReplaceUseApp($tandem->basePath(), $tandem->fullyQualifiedNamespace()),
            new ReplaceUseDatabase($tandem->basePath(), $tandem->fullyQualifiedNamespace()),
            new ReplaceAppModelsUserInAuthConfig($tandem->basePath(), $tandem->fullyQualifiedNamespace()),
        ];
    }

    public function __invoke(Tandem $tandem): void
    {
        app(InvokeFindReplaceInFiles::class)(...$this->replacers($tandem));
    }
}