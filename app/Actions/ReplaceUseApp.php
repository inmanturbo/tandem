<?php

namespace Inmanturbo\Tandem\Actions;

class ReplaceUseApp extends FindAndReplaceInFiles
{
    public string $search = 'use App';

    public function __construct(
        public string $basePath,
        public string $namespace,
        public string|array|null $path = null,
    ) {
        parent::__construct($this->search, "use {$namespace}", $basePath, $path);
    }
}
