<?php

namespace Inmanturbo\Tandem;

class ReplaceUseDatabase extends FindAndReplaceOperation
{
    public string $search = 'use Database';

    public function __construct(
        public string $namespace,
        public string $path = '*',
    )
    {
        parent::__construct($this->search, "use {$namespace}\\Database", $path);
    }
}
