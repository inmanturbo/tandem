<?php

namespace Inmanturbo\Tandem;

class ReplaceNamespaceApp extends ReplaceInFiles
{
    public string $search = 'namespace App';

    public function __construct(
        public string $namespace,
        public string $path = 'app/**/*.php',
    ) {
        parent::__construct($this->search, "namespace {$namespace}", $path);
    }
}
