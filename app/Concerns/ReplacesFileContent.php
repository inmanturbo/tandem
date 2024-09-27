<?php

namespace Inmanturbo\Tandem\Concerns;

use Inmanturbo\Tandem\FindAndReplaceOperation;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

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

    protected function fileGlob($basePath, string $relativePath = '*') : array
    {
        $filePattern = join_paths($basePath, $relativePath);

        if (str_contains($relativePath, '**')) {
            return $this->recursiveGlob($filePattern);
        }

        return $this->onlyFiles(glob($filePattern, GLOB_BRACE));
    }

    protected function recursiveGlob(string $pattern): array
    {
        $paths = [];
        $directory = dirname($pattern);
        $filePattern = basename($pattern);

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && fnmatch($filePattern, $file->getFilename())) {
                $paths[] = $file->getRealPath();
            }
        }

        return $this->onlyFiles($paths);
    }

    protected function onlyFiles(array $glob): array
    {
        return array_filter($glob, 'is_file');
    }
}
