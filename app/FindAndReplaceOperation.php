<?php

namespace Inmanturbo\Tandem;

class FindAndReplaceOperation
{
    
    public function __construct(
        public string $search,
        public string $replace,
        public string $path = '*',
    )
    {}

    public static function make(...$args): static
    {
        return new static(...$args);
    }
}
