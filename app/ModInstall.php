<?php

namespace Inmanturbo\Tandem;

use Illuminate\Support\Str;

use function Illuminate\Filesystem\join_paths;

class ModInstall
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $mod,
        public string $modNamespace,
        public string $vendorNamespace = 'Mod',
        public bool $isVerbose = false,
    ) {
        //
    }

    public function basePath(): string
    {
        return join_paths(base_path(), 'mod', $this->mod);
    }

    public function stubPath()
    {
        return join_paths(base_path(), 'stubs', 'mod');
    }

    public function composerFile()
    {
        return join_paths($this->basePath(), 'composer.json');
    }

    public function packageName(): string
    {
        return implode('/', [
            (string) Str::of($this->vendorNamespace)->kebab()->lower(),
            (string) Str::of($this->mod)->kebab()->lower(),
        ]);
    }

    public function fullyQualifiedNamespace(): string
    {
        return "{$this->vendorNamespace}\\{$this->modNamespace}";
    }

    public function isVerbose(): bool
    {
        return $this->isVerbose;
    }
}
