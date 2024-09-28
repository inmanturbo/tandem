<?php

namespace Inmanturbo\Tandem;

class ReplaceNamespaceApp extends ReplaceInFiles
{
    public string $search = 'namespace App';

    public function __construct(
        public string $namespace,
        public string|array|null $path = null,
    ) {
        parent::__construct($this->search, "namespace {$namespace}", $path);
    }
}
