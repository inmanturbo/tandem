<?php

namespace Inmanturbo\Tandem\Tasks;

use Inmanturbo\Tandem\Actions\UpdateComposerJson;
use Inmanturbo\Tandem\ComposerPackageData;
use Inmanturbo\Tandem\ModInstall;

class ConfigureComposer
{
    public function __invoke(ModInstall $mod): ModInstall
    {
        $packageData = new ComposerPackageData($mod->fullyQualifiedNamespace(), $mod->packageName());

        app(UpdateComposerJson::class)($mod->composerFile(), $packageData->data());

        return $mod;
    }
}
