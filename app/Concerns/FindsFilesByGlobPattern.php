<?php

namespace Inmanturbo\Tandem\Concerns;

use Illuminate\Support\Facades\File;
use Inmanturbo\Tandem\FilepathPattern;

trait FindsFilesByGlobPattern
{
    public function files(FilepathPattern $pattern): array
    {
        return $this->findFilesByPattern($pattern->pattern);
    }

    protected function findFilesByPattern(string $pattern): array
    {
        return match (true) {
            str_contains($pattern, '**') => $this->findByDoubleGlob($pattern),
            str_contains($pattern, '*') => $this->findByGlob($pattern),
            default => is_file($pattern) ? [$pattern] : [],
        };
    }

    protected function findByGlob(string $pattern): array
    {
        return array_filter($files = glob($pattern), fn ($file): bool => is_file($file));
    }

    protected function findByDoubleGlob(string $pattern): array
    {
        $basePath = substr($pattern, 0, strpos($pattern, '/**'));

        $files = File::allFiles($basePath);

        if (basename($pattern) === '**') {
            return $files;
        }

        $filename = basename($pattern);

        return array_filter($files, fn ($file): bool => fnmatch($filename, $file->getFilename()));
    }
}
