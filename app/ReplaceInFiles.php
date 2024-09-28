<?php

namespace Inmanturbo\Tandem;

use Symfony\Component\Finder\Finder;

class ReplaceInFiles
{
    public function __construct(
        public string $search,
        public string $replace,
        public string|array|null $path = null,
    ) {}

    public static function make(...$args): static
    {
        return new static(...$args);
    }

    public function find(string $basePath): \Symfony\Component\Finder\Finder
    {
        $finder = (new Finder)->in($basePath);

        if ($this->path) {
            $finder->path($this->path);
        }

        return $finder->name('*.php');
    }
}
