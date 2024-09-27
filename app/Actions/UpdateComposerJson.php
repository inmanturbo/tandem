<?php

namespace Inmanturbo\Tandem\Actions;

class UpdateComposerJson
{
    public function update(string $composerFilePath, array $updatedData)
    {
        file_put_contents($composerFilePath, json_encode(
            array_merge(json_decode(file_get_contents($composerFilePath), true), $updatedData), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        ));
    }
}
