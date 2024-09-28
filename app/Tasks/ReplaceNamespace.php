<?php

namespace Inmanturbo\Tandem\Tasks;

use Inmanturbo\Tandem\Actions\FindAndReplaceInFiles;
use Inmanturbo\Tandem\ModInstall;
use Inmanturbo\Tandem\ReplaceNamespaceApp;
use Inmanturbo\Tandem\ReplaceNamespaceDatabase;
use Inmanturbo\Tandem\ReplaceUseApp;
use Inmanturbo\Tandem\ReplaceUseDatabase;

class ReplaceNamespace
{
    protected function replacers(string $replacement): array
    {
        return [
            new ReplaceNamespaceApp($replacement),
            new ReplaceNamespaceDatabase($replacement),
            new ReplaceUseApp($replacement),
            new ReplaceUseDatabase($replacement),
        ];
    }

    public function __invoke(ModInstall $mod): ModInstall
    {
        app(FindAndReplaceInFiles::class)($mod->basePath(), ...$this->replacers($mod->fullyQualifiedNamespace()));

        return $mod;
    }
}
