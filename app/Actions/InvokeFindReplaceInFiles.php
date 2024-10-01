<?php

namespace Inmanturbo\Tandem\Actions;

class InvokeFindReplaceInFiles
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(FindAndReplaceInFiles ...$actions): void
    {
        foreach ($actions as $action) {
            foreach ($action->find() as $file) {
                app(InvokeReplaceInFile::class)(new ReplaceInFile($action->search, $action->replace, $file));
            }
        }
    }
}
