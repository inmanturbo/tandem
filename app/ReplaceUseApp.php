<?php

namespace Inmanturbo\Tandem;

class ReplaceUseApp extends FindAndReplaceOperation
{
    public string $search = 'use App';

    public function __construct(
        public string $namespace,
        public string $path = '*',
    )
    {
        parent::__construct($this->search, "use {$namespace}", $path);
    }
}
