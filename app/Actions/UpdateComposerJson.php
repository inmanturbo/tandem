<?php

namespace Inmanturbo\Tandem\Actions;

class UpdateComposerJson
{
    public function __invoke(string $composerFilePath, array $updatedData): void
    {
        file_put_contents($composerFilePath, json_encode(
            array_merge(json_decode(file_get_contents($composerFilePath), true), $updatedData), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        ));
    }
}
