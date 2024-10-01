<?php

namespace Inmanturbo\Tandem\Actions;

use Symfony\Component\Finder\Finder;

class FindAndReplaceInFiles
{
    public function __construct(
        public string $search,
        public string $replace,
        public string $basePath,
        public string|array|null $path = null,
    ) {}

    public static function make(...$args): static
    {
        return new static(...$args);
    }

    public function find(): Finder
    {
        $finder = (new Finder)->in($this->basePath)->notPath('#(vendor|temp|tmp|e2e|bin|build|storage|node_modules)#');

        if ($this->path) {
            $finder->path($this->path);
        }

        return $finder->name('*.php');
    }
}
