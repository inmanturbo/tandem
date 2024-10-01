<?php

namespace Inmanturbo\Tandem\Actions;

class UpdateComposerJson
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $composerFilePath,
        public array $updatedData,
    ) {
        //
    }
}
