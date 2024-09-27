<?php

namespace Inmanturbo\Tandem;

class ReplaceNamespaceDatabase extends FindAndReplaceOperation
{
    public string $search = 'namespace Database';

    public function __construct(
        public string $namespace,
        public string $path = 'database/*',
    )
    {
        parent::__construct($this->search, "namespace {$namespace}", $path);
    }
}
