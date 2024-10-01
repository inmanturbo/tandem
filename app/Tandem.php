<?php

namespace Inmanturbo\Tandem;

use Illuminate\Support\Str;

use function Illuminate\Filesystem\join_paths;

class Tandem
{
    public function __construct(
        public string $mod,
        public string $modNamespace,
        public string $vendorNamespace = 'Mod',
        public bool $verbose = false,
        public bool $init = false,
        public bool $install = false,
    ) {
        //
    }

    public function modName()
    {
        return $this->mod;
    }

    public function basePath(): string
    {
        return join_paths($this->repositoryPath(), $this->mod);
    }

    public function repositoryPath(): string
    {
        return join_paths(base_path(), 'mod');
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
        return $this->verbose;
    }

    public function composer(): array
    {
        return ['composer'];
    }

    public function laravel(): array
    {
        return ['laravel'];
    }

    public function shouldInitializeRepository(): bool
    {
        return $this->init;
    }

    public function shouldRequireMod(): bool
    {
        return $this->install;
    }
}
