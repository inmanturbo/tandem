<?php

namespace Inmanturbo\Tandem;

class ReplaceUseApp extends ReplaceInFiles
{
    public string $search = 'use App';

    public function __construct(
        public string $namespace,
        public string|array|null $path = null,
    ) {
        parent::__construct($this->search, "use {$namespace}", $path);
    }
}
