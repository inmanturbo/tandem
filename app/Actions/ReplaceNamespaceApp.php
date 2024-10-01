<?php

namespace Inmanturbo\Tandem\Actions;

class ReplaceNamespaceApp extends FindAndReplaceInFiles
{
    public string $search = 'namespace App';

    public function __construct(
        public string $basePath,
        public string $namespace,
        public string|array|null $path = null,
    ) {
        parent::__construct($this->search, "namespace {$namespace}", $basePath, $path);
    }
}
