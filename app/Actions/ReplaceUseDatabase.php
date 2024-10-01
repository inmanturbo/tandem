<?php

namespace Inmanturbo\Tandem\Actions;

class ReplaceUseDatabase extends FindAndReplaceInFiles
{
    public string $search = 'use Database';

    public function __construct(
        public string $basePath,
        public string $namespace,
        public string|array|null $path = null,
    ) {
        parent::__construct($this->search, "use {$namespace}\\Database", $basePath, $path);
    }
}
