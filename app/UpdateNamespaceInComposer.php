<?php

namespace Inmanturbo\Tandem;

use Inmanturbo\Tandem\Actions\InvokeUpdateComposerJson;
use Inmanturbo\Tandem\Actions\UpdateComposerJson;

class UpdateNamespaceInComposer implements HandlesTandem
{
    public function __invoke(Tandem $tandem): void
    {
        app(InvokeUpdateComposerJson::class)(new UpdateComposerJson($tandem->composerFile(), $this->composerPackageData($tandem)));
    }

    protected function composerPackageData(Tandem $tandem): array
    {
        $data = new ComposerPackageData($tandem->fullyQualifiedNamespace(), $tandem->packageName());

        return $data->data();
    }
}
