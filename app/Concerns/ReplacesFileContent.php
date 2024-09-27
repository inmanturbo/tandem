<?php

namespace Inmanturbo\Tandem\Concerns;

use Inmanturbo\Tandem\Contracts\FindsFilesByFilepathPattern;
use Inmanturbo\Tandem\FilepathPattern;
use Inmanturbo\Tandem\FindAndReplaceOperation;

trait ReplacesFileContent
{
    protected function replaceInFile(string|array $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    protected function replaceInFiles($basePath, FindAndReplaceOperation ...$operations): void
    {
        foreach ($operations as $operation) {
            foreach ($this->fileGlob($basePath, $operation->path) as $path) {
                $this->replaceInFile($operation->search, $operation->replace, $path);
            }
        }
    }

    protected function fileGlob($basePath, string $relativePath = '*'): array
    {
        return app(FindsFilesByFilepathPattern::class)->find(new FilepathPattern($basePath, $relativePath));
    }
}
