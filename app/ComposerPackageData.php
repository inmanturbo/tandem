<?php

namespace Inmanturbo\Tandem;

class ComposerPackageData
{
    public array $data;

    public function __construct(
        public string $namespace,
        public string $name,
    ) {
        $this->data['autoload']['psr-4'] = [
            "{$namespace}\\Database\\Factories\\" => 'database/factories/',
            "{$namespace}\\Database\\Seeders\\" => 'database/seeders/',
            "{$namespace}\\" => 'app/',
        ];

        $this->data['name'] = $name;

        $this->data['extra']['laravel']['providers'] = ["{$namespace}\\Providers\\AppServiceProvider"];
    }

    public function data(): array
    {
        return $this->data;
    }
}
