<?php

namespace Inmanturbo\Tandem;

use function Illuminate\Filesystem\join_paths;

class FilepathPattern
{
    public string $pattern;

    public function __construct(
        public string $basePath,
        public string $relativePattern = '*',
    ) {
        $this->pattern = $this->joinPattern($basePath, $relativePattern);
    }

    protected function joinPattern($basePath, $relativePattern)
    {
        if (! str_contains((string) $relativePattern, '/') && ! str_contains((string) $relativePattern, '\\')) {

            return join_paths($basePath, $relativePattern);
        }

        return join_paths($basePath, ...explode(
            DIRECTORY_SEPARATOR,
            str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePattern),
        ));
    }
}
