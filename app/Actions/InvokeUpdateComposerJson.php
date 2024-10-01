<?php

namespace Inmanturbo\Tandem\Actions;

class InvokeUpdateComposerJson
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(UpdateComposerJson $action): void
    {
        file_put_contents($action->composerFilePath, json_encode(
            array_merge(json_decode(file_get_contents($action->composerFilePath), true), $action->updatedData), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        ));
    }
}
