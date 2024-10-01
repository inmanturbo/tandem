<?php

namespace Inmanturbo\Tandem\Actions;

class ReplaceNamespaceDatabase extends FindAndReplaceInFiles
{
    public string $search = 'namespace Database';

    public function __construct(
        public string $basePath,
        public string $namespace,
        public string|array|null $path = null,
    ) {
        parent::__construct($this->search, "namespace {$namespace}\\Database", $basePath, $path);
    }
}
