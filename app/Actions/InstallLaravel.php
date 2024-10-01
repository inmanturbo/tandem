<?php

namespace Inmanturbo\Tandem\Actions;

use Closure;

class InstallLaravel
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $path,
        public array $laravel,
        public array $args,
        public ?Closure $output = null,
    ) {
        //
    }
}
