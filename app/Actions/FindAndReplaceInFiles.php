<?php

namespace Inmanturbo\Tandem\Actions;

use Inmanturbo\Tandem\ReplaceInFiles;

class FindAndReplaceInFiles
{
    public function __invoke(string $basePath, ReplaceInFiles ...$operations): void
    {
        foreach ($operations as $operation) {
            foreach ($operation->find($basePath) as $file) {
                $this->replaceInFile($operation->search, $operation->replace, $file);
            }
        }
    }

    protected function replaceInFile(string|array $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
