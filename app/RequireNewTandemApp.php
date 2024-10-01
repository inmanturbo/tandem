<?php

namespace Inmanturbo\Tandem;

use Inmanturbo\Tandem\Actions\ComposerCommand;
use Inmanturbo\Tandem\Actions\InvokeComposerCommand;
use Inmanturbo\Tandem\Actions\InvokeOutput;
use Inmanturbo\Tandem\Actions\Output;

class RequireNewTandemApp implements HandlesTandem
{
    /**
     * Create a new class instance.
     */
    public function __invoke(Tandem $tandem): void
    {
        if (! $tandem->shouldRequireMod()) {
            return;
        }

        app(InvokeComposerCommand::class)(new ComposerCommand(base_path(), $tandem->composer(), [
            'require',
            "{$tandem->packageName()}:*",
        ],
            function (string $type, string $output): void {
                app(InvokeOutput::class)(new Output($output));
            }
        ));
    }
}
