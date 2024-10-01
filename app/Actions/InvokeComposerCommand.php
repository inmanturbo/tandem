<?php

namespace Inmanturbo\Tandem\Actions;

use Illuminate\Contracts\Process\ProcessResult;
use Illuminate\Support\Facades\Process;

class InvokeComposerCommand
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(ComposerCommand $action): ProcessResult
    {
        return match (is_null($action->callback)) {
            true => Process::path($action->path)->run([...$action->composer, ...$action->args]),
            default => Process::path($action->path)->run([...$action->composer, ...$action->args], $action->callback),
        };
    }
}
