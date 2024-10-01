<?php

namespace Inmanturbo\Tandem\Actions;

class InvokeReplaceInFile
{
    public function __invoke(ReplaceInFile $action): void
    {
        file_put_contents($action->path, str_replace($action->search, $action->replace, file_get_contents($action->path)));
    }
}
