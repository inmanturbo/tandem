<?php

namespace Inmanturbo\Tandem\Actions;

use Inmanturbo\Tandem\Contracts\FileGlob;
use Inmanturbo\Tandem\FilepathPattern;
use Inmanturbo\Tandem\ReplaceInFiles;

class FindAndReplaceInFiles
{
    public function handle($basePath, ReplaceInFiles ...$operations): void
    {
        foreach ($operations as $operation) {
            foreach ($this->fileGlob($basePath, $operation->path) as $path) {
                $this->replaceInFile($operation->search, $operation->replace, $path);
            }
        }
    }

    protected function replaceInFile(string|array $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    protected function fileGlob($basePath, string $relativePattern = '*'): array
    {
        return app(FileGlob::class)->files(new FilepathPattern($basePath, $relativePattern));
    }
}
