<?php

namespace Inmanturbo\Tandem;

use Inmanturbo\Tandem\Actions\ComposerCommand;
use Inmanturbo\Tandem\Actions\InvokeComposerCommand;
use Inmanturbo\Tandem\Actions\InvokeOutput;
use Inmanturbo\Tandem\Actions\Output;

class RunComposerCommandsInTandem implements HandlesTandem
{
    public function __invoke(Tandem $tandem): void
    {
        if (! $tandem->basePath() || ! $tandem->composer()) {
            return;
        }

        foreach ($this->composerCommands($tandem) as $command) {
            app(InvokeComposerCommand::class)(new ComposerCommand(
                $tandem->basePath(),
                $tandem->composer(),
                $command,
                function (string $type, string $output): void {
                    app(InvokeOutput::class)(new Output($output));
                }
            ));

            app(InvokeOutput::class)(new Output('Module setup completed successfully.'));
        }
    }

    protected function composerCommands(Tandem $tandem): array
    {
        return [
            [
                'require',
                '--dev',
                'rector/rector',
                'phpstan/phpstan',
            ],
            [
                'config',
                'repositories.mod',
                $repositoryConfig = json_encode([
                    'type' => 'path',
                    'url' => '../*',
                    'options' => ['symlink' => false],
                ]),
                '--file',
                'composer.json',
            ],
            [
                'config',
                'minimum-stability',
                'dev',
            ],
        ];
    }
}
