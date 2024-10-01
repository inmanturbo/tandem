<?php

namespace Inmanturbo\Tandem\Actions;

class ReplaceAppModelsUserInAuthConfig extends FindAndReplaceInFiles
{
    public string $search = 'App\Models\User::class';

    public function __construct(
        public string $basePath,
        public string $namespace,
        public string|array|null $path = 'config/auth.php',
    ) {
        parent::__construct($this->search, "{$namespace}\Models\User::class", $basePath, $path);
    }
}
