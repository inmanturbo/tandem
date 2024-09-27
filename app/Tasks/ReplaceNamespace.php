<?php

namespace Inmanturbo\Tandem\Tasks;

use Inmanturbo\Tandem\Actions\FindAndReplaceInFiles;
use Inmanturbo\Tandem\ReplaceNamespaceApp;
use Inmanturbo\Tandem\ReplaceNamespaceDatabase;
use Inmanturbo\Tandem\ReplaceUseApp;
use Inmanturbo\Tandem\ReplaceUseDatabase;

class ReplaceNamespace
{
    protected function tasks(string $replacement): array
    {
        return [
            new ReplaceNamespaceApp($replacement),
            new ReplaceNamespaceDatabase($replacement),
            new ReplaceUseApp($replacement),
            new ReplaceUseDatabase($replacement),
        ];
    }


    public function run(string $basePath, string $replacement): void
    {
        app(FindAndReplaceInFiles::class)->handle($basePath, ...$this->tasks($replacement));
    }
}
