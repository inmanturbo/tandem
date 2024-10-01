<?php

namespace Inmanturbo\Tandem\Actions;

class ReplaceInFile
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string|array $search,
        public string $replace,
        public string $path
    ) {
        //
    }
}
