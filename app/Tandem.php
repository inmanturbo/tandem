<?php

namespace Inmanturbo\Tandem;

use Illuminate\Support\Str;

use function Illuminate\Filesystem\join_paths;

class Tandem
{
    public function __construct(
        public ?string $modName = null,
        public ?string $appNamespace = null,
        public ?string $vendorNamespace = 'Mod',
        public bool $verbose = false,
        public bool $init = false,
        public bool $install = false,
    ) {
        //
    }

    public function modName(): ?string
    {
        return $this->modName;
    }

    public function basePath(): ?string
    {
        if (! $this->modName) {
            return null;
        }

        return join_paths($this->repositoryPath(), $this->modName);
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

    public function packageName(): ?string
    {
        if (! $this->vendorNamespace || ! $this->modName) {
            return null;
        }

        return implode('/', [
            (string) Str::of($this->vendorNamespace)->kebab()->lower(),
            (string) Str::of($this->modName)->kebab()->lower(),
        ]);
    }

    public function fullyQualifiedNamespace(): ?string
    {
        if (! $this->vendorNamespace || ! $this->appNamespace) {
            return null;
        }

        return "{$this->vendorNamespace}\\{$this->appNamespace}";
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
