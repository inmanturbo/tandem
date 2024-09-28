<?php

namespace Inmanturbo\Tandem;

class ReplaceNamespaceDatabase extends ReplaceInFiles
{
    public string $search = 'namespace Database';

    public function __construct(
        public string $namespace,
        public string|array|null $path = null,
    ) {
        parent::__construct($this->search, "namespace {$namespace}\\Database", $path);
    }
}
