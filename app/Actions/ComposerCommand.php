<?php

namespace Inmanturbo\Tandem\Actions;

use Closure;

class ComposerCommand
{
    public function __construct(
        public string $path,
        public array $composer,
        public array $args,
        public ?Closure $callback = null,
    ) {
        //
    }
}
