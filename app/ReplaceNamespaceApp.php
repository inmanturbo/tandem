<?php

namespace Inmanturbo\Tandem;

class ReplaceNamespaceApp extends FindAndReplaceOperation
{
    public string $search = 'namespace App';

    public function __construct(
        public string $namespace,
        public string $path = 'app/*',
    )
    {
        parent::__construct($this->search, "namespace {$namespace}", $path);
    }
}
