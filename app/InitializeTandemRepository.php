<?php

namespace Inmanturbo\Tandem;

use Illuminate\Support\Arr;
use Inmanturbo\Tandem\Actions\ComposerCommand;
use Inmanturbo\Tandem\Actions\InvokeComposerCommand;
use Inmanturbo\Tandem\Actions\InvokeOutput;
use Inmanturbo\Tandem\Actions\Output;

class InitializeTandemRepository implements HandlesTandem
{
    public function __invoke(Tandem $tandem): void
    {
        if (! $tandem->shouldInitializeRepository()) {
            return;
        }

        app(InvokeComposerCommand::class)(new ComposerCommand(base_path(), $tandem->composer(), [
                'config',
                'repositories.mod',
                $repositoryConfig = json_encode([
                    'type' => 'path',
                    'url' => 'mod/*',
                    'options' => ['symlink' => true],
                ]),
                '--file',
                'composer.json',
            ],
            function (string $type, string $output): void {
                app(InvokeOutput::class)(new Output($output));
            }),
        );
    }
}
