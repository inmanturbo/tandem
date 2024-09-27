<?php

namespace Inmanturbo\Tandem\Concerns;

use Inmanturbo\Tandem\FindAndReplaceOperation;

use function Illuminate\Filesystem\join_paths;

trait ReplacesFileContent
{
    protected function replaceInFile(string|array $search, string $replace, string $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    protected function replaceFileContents($basePath, FindAndReplaceOperation ...$operations)
    {
        foreach ($operations as $operation) {
            foreach ($this->fileGlob($basePath, $operation->path) as $path) {
                $this->replaceInFile($operation->search, $operation->replace, $path);
            }
        }
    }

    protected function fileGlob($basePath, string $relativePath = '*') : array|false
    {
        if (! str_contains($relativePath, '/') && ! str_contains($relativePath, '\\')) {
            $filePattern = join_paths($basePath, $relativePath);

            return $this->onlyFiles(glob($filePattern, GLOB_BRACE));
        }

        $filePattern = join_paths($basePath, ...explode(
            DIRECTORY_SEPARATOR,
            str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath),
        ));

        return $this->onlyFiles(glob($filePattern, GLOB_BRACE));
    }

    protected function onlyFiles(array $glob)
    {
        return array_filter($glob, 'is_file');
    }
}
