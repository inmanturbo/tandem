<?php

namespace Inmanturbo\Tandem;

class ComposerPackageData
{
    public array $data;

    public function __construct(
        public string $namespace,
        public ?string $name = null,
    ) {
        $this->data['autoload']['psr-4'] = [
            "{$namespace}\\Database\\Factories\\" => 'database/factories/',
            "{$namespace}\\Database\\Seeders\\" => 'database/seeders/',
            "{$namespace}\\" => 'app/',
        ];

        if ($name) {
            $this->data['name'] = $name;
        }

        $this->data['extra']['laravel']['providers'] = ["{$namespace}\\Providers\\AppServiceProvider"];
    }

    public function data(): array
    {
        return $this->data;
    }
}
