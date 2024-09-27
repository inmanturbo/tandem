<?php

namespace Inmanturbo\Tandem\Concerns;

use Illuminate\Support\Facades\File;
use Inmanturbo\Tandem\FindAndReplaceOperation;

use function Illuminate\Filesystem\join_paths;

trait ReplacesFileContent
{
    protected function replaceInFile(string|array $search, string $replace, string $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    protected function replaceFileContent($basePath, FindAndReplaceOperation ...$operations)
    {
        foreach ($operations as $operation) {
            foreach ($this->fileGlob($basePath, $operation->path) as $path) {
                $this->replaceInFile($operation->search, $operation->replace, $path);
            }
        }
    }

    protected function filePattern($basePath, string $relativePath = '*') : string
    {
        if (! str_contains($relativePath, '/') && ! str_contains($relativePath, '\\')) {

            return join_paths($basePath, $relativePath);
        }

        return join_paths($basePath, ...explode(
            DIRECTORY_SEPARATOR,
            str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath),
        ));
    }

    protected function onlyFiles(array $glob)
    {
        return array_filter($glob, 'is_file');
    }

    protected function fileGlob($basePath, string $relativePath = '*') : array|false
    {
        $pattern = $this->filePattern($basePath, $relativePath);

        return $this->findFilesByPattern($pattern);
    }

    public function findFilesByPattern(string $pattern): array|false
    {   
        if (str_contains($pattern, '**')) {
            $basePath = substr($pattern, 0, strpos($pattern, '/**'));

            $files = File::allFiles($basePath);
            
            if (basename($pattern) == '**') {
                return $files;
            }

            $filename = basename($pattern);
            
            return array_filter($files, function ($file) use ($filename) {
                return fnmatch($filename, $file->getFilename());
            });
        }elseif (str_contains($pattern, '*')) {
            return array_filter($files = glob($pattern), function ($file) {
                return is_file($file);
            });
        }

        return is_file($pattern) ? [$pattern] : [];
    }
}
