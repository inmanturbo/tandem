<?php

namespace Inmanturbo\Tandem;

class ReplaceUseDatabase extends ReplaceInFiles
{
    public string $search = 'use Database';

    public function __construct(
        public string $namespace,
        public string|array|null $path = null,
    ) {
        parent::__construct($this->search, "use {$namespace}\\Database", $path);
    }
}
