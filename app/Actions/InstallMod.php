<?php

namespace Inmanturbo\Tandem\Actions;

use Inmanturbo\Tandem\ModInstall;
use Inmanturbo\Tandem\Tasks\ConfigureComposer;
use Inmanturbo\Tandem\Tasks\InstallStubs;
use Inmanturbo\Tandem\Tasks\ReplaceNamespace;

class InstallMod
{
    protected $tasks = [
        InstallStubs::class,
        ReplaceNamespace::class,
        ConfigureComposer::class,
    ];

    public function install(ModInstall $mod): void
    {
        foreach ($this->tasks as $task) {
            app($task)($mod);
        }
    }
}
